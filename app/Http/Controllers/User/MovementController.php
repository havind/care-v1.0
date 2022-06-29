<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\{BudgetLine,
    FundCode,
    Location,
    MovementRequest,
    MrAccommodation,
    MrApproval,
    MrFinanceAccommodation,
    MrFinanceItem,
    MrFinancePassenger,
    MrItem,
    MrItinerary,
    MrPassengers,
    User,
};
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ibFunctions;
use Illuminate\Support\Facades\DB;


class MovementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $movemetns_from_items = DB::select('SELECT mr.id AS mr_id FROM mr_approvals AS a
                                                    INNER JOIN movement_requests mr ON a.mr_id = mr.id
                                                    WHERE (mr.is_delete = 0 AND a.items_approval = 0 AND mr.requester_id = ' . Auth::id() . ');');
        $movemetns_from_passengers = DB::select('SELECT mr.id AS mr_id FROM mr_passengers AS mp
                                                        INNER JOIN movement_requests mr on mp.mr_id = mr.id
                                                        WHERE (mr.is_delete = 0 AND mp.passenger_id = ' . Auth::id() . ');');
        $movements = array_merge($movemetns_from_passengers, $movemetns_from_items);
        $filtered_movements = [];
        foreach ($movements as $movement) {
            array_push($filtered_movements, $movement->mr_id);
        }
        $filtered_movements = array_unique($filtered_movements);

        if (empty($filtered_movements) == false) {
            $mrs = DB::select('SELECT mr.id, mr.name, mr.requester_id, mr.purpose, mr.is_canceled, mr.created_at FROM movement_requests AS mr WHERE id IN (' . implode(', ', $filtered_movements) . ');');
        } else {
            $mrs = null;
        }

        $passengers = MrPassengers::select('id', 'mr_id', 'passenger_id')
            ->where('is_delete', 0)
            ->whereIn('mr_id', $filtered_movements)
            ->get();

        $itineraries = MrItinerary::select()
            ->where('is_delete', 0)
            ->whereIn('mr_id', $filtered_movements)
            ->get();

        $locations = Location::select('id', 'name')
            ->where('is_delete', 0)
            ->get();

        $users = User::select('id', 'first_name', 'last_name')
            ->get();

        $approvals = MrApproval::select('id', 'mr_id', 'line_manager_approval', 'items_approval_name', 'items_approval', 'items_approval_reason', 'items_approval_timestamp', 'risk_approval_name', 'risk_approval', 'risk_reason', 'risk_timestamp', 'country_director_approval_name', 'country_director_approval', 'country_director_reason', 'country_director_timestamp')
            ->whereIn('mr_id', $filtered_movements)
            ->where('is_delete', 0)
            ->get();

        return view('users.movements.index', [
            'active_primary_menu' => 'movements',
            'my_movements' => $mrs,
            'users' => $users,
            'passengers' => $passengers,
            'itineraries' => $itineraries,
            'locations' => $locations,
            'approvals' => $approvals,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('is_active', true)
            ->where('is_delete', false)
            ->orderBy('first_name')
            ->get(['id', 'first_name', 'last_name',]);

        $locations = Location::select('id', 'name', 'is_krg', 'is_available', 'is_accommodation')
            ->orderBy('name')
            ->where('is_delete', false)
            ->get();

        return view('users.movements.create', [
            'title' => 'New Movement Request',
            'users' => $users,
            'locations' => $locations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * Generate Movement Request unique ID.
         */
        $generated_mr_id = 'MR-' . Auth::id() . '-' . date('y') . date('m') . date('d') . date('h') . date('i') . date('s');

        /**
         * Store Movement Request into the system.
         */
        MovementRequest::insert([
            'name' => $generated_mr_id,
            'requester_id' => Auth::id(),
            'purpose' => strip_tags($request->input('mv-purpose'), '<ul><ol><li><table><tr><th><td><i><p><strong><i><a>'),
            'created_at' => now(),
        ]);

        /**
         * Get newly saved record.
         */
        $movement_request_id = (MovementRequest::select('id')->firstWhere('name', $generated_mr_id))->id;


        //Variable
        $is_outside_krg = 0;

        /**
         * Store Itinerary into the system.
         */
        for ($i = 1; $i <= 15; $i++) {
            if ($request->input('iti-' . $i . '-from-location') > 0 && $request->input('iti-' . $i . '-to-location') > 0) {
                if ($request->input('iti-' . $i . '-from-date') != '' && $request->input('iti-' . $i . '-to-date') != '') {
                    if ($request->input('iti-' . $i . '-from-time') != '' && $request->input('iti-' . $i . '-to-time') != '') {
                        MrItinerary::insert([
                            'mr_id' => $movement_request_id,
                            'from_location_id' => $request->input('iti-' . $i . '-from-location'),
                            'from_date' => $request->input('iti-' . $i . '-from-date'),
                            'from_time' => $request->input('iti-' . $i . '-from-time'),
                            'to_location_id' => $request->input('iti-' . $i . '-to-location'),
                            'to_date' => $request->input('iti-' . $i . '-to-date'),
                            'to_time' => $request->input('iti-' . $i . '-to-time'),
                            'created_at' => now(),
                        ]);
                    }

                    $locations = Location::select('id', 'name', 'is_krg')
                        ->where('is_krg', 0)
                        ->get();

                    foreach ($locations as $location) {
                        if ($location->id == $request->input('iti-' . $i . '-from-location')) {
                            $is_outside_krg = 1;
                        }
                        if ($location->id == $request->input('iti-' . $i . '-to-location')) {
                            $is_outside_krg = 1;
                        }
                    }
                }
            }
        }

        /**
         * Store Passengers into the system.
         */
        // Check if Passengers section ia activated.
        if ($request->input('passengers-check') == 'on') {
            for ($i = 1; $i <= 6; $i++) {
                if ($request->input('pax-' . $i . '-name') !== null) {
                    if ($request->input('pax-' . $i . '-name') != 0) {
                        $passenger_id = $request->input('pax-' . $i . '-name');
                        // Check if passenger is country director.
                        if (ibFunctions::check_permission_by_user($passenger_id, 'risk_movementRequest_approvals_cd')) {
                            $line_manager_approval = 1;
                            $line_manager_approval_timestamp = now();
                        } else {
                            $line_manager_approval = 0;
                            $line_manager_approval_timestamp = null;
                        }
                        // Store passengers into system.
                        MrPassengers::insert([
                            'mr_id' => $movement_request_id,
                            'passenger_id' => $passenger_id,
                            'line_manager_approval' => $line_manager_approval,
                            'line_manager_reason' => null,
                            'line_manager_timestamp' => $line_manager_approval_timestamp,
                            'created_at' => now(),
                        ]);

                        // Store passengers finance into system.
                        for ($j = 1; $j <= 3; $j++) {
                            if ($request->input('pax-' . $i . '-fc-' . $j) > null &&
                                $request->input('pax-' . $i . '-bl-' . $j) > null &&
                                $request->input('pax-' . $i . '-pr-' . $j) > null) {
                                if ($request->input('pax-' . $i . '-fc-' . $j) > 0 &&
                                    $request->input('pax-' . $i . '-bl-' . $j) > 0 &&
                                    $request->input('pax-' . $i . '-pr-' . $j) > 0) {
                                    MrFinancePassenger::insert([
                                        'mr_id' => $movement_request_id,
                                        'user_id' => $passenger_id,
                                        'fund_code_id' => $request->input('pax-' . $i . '-fc-' . $j),
                                        'budget_line_id' => $request->input('pax-' . $i . '-bl-' . $j),
                                        'percentage' => $request->input('pax-' . $i . '-pr-' . $j),
                                        'created_at' => now()
                                    ]);
                                }
                            }
                        }
                    }
                }
            }

            // Check if accommodation section ia activated.
            if ($request->input('accommodation-check') == 'on') {
                // Store accommodation into system.
                for ($i = 1; $i <= 6; $i++) {
                    if ($request->input('acm-' . $i . '-name') !== null) {
                        if ($request->input('acm-' . $i . '-name') != 0) {
                            if ($request->input('acm-1-location') > 0) {
                                // Store accommodation into system.
                                $accommodation = new MrAccommodation();

                                $accommodation->mr_id = $movement_request_id;
                                $accommodation->user_id = $request->input('acm-' . $i . '-name');
                                $accommodation->check_in = $request->input('acm-' . $i . '-check-in');
                                $accommodation->check_out = $request->input('acm-' . $i . '-check-out');
                                $accommodation->location_id = $request->input('acm-' . $i . '-location');

                                $accommodation->save();

                                // Store accommodation finance into system.
                                for ($j = 1; $j <= 3; $j++) {

                                    if ($request->input('acm-' . $i . '-fc-' . $j) > null &&
                                        $request->input('acm-' . $i . '-bl-' . $j) > null &&
                                        $request->input('acm-' . $i . '-pr-' . $j) > null) {
                                        if ($request->input('acm-' . $i . '-fc-' . $j) > 0 &&
                                            $request->input('acm-' . $i . '-bl-' . $j) > 0 &&
                                            $request->input('acm-' . $i . '-pr-' . $j) > 0) {

                                            $accommodationFinance = new MrFinanceAccommodation();

                                            $accommodationFinance->mr_id = $movement_request_id;
                                            $accommodationFinance->accommodations_id = $accommodation->id;
                                            $accommodationFinance->fund_code_id = $request->input('acm-' . $i . '-fc-' . $j);
                                            $accommodationFinance->budget_line_id = $request->input('acm-' . $i . '-bl-' . $j);
                                            $accommodationFinance->percentage = $request->input('acm-' . $i . '-pr-' . $j);

                                            $accommodationFinance->save();

                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        /**
         * Store Items into system.
         */
        $items_approval = 4;
        if ($request->input('items-check') == 'on') {
            for ($i = 1; $i <= 15; $i++) {
                if ($request->input('itm-' . $i . '-name') !== null) {

                    // Store items into system.
                    MrItem::insert([
                        'mr_id' => $movement_request_id,
                        'description' => $request->input('itm-' . $i . '-name'),
                        'created_at' => now(),
                    ]);

                    $item_id = (MrItem::select('id')
                        ->orderBy('id')
                        ->firstWhere('mr_id', $movement_request_id))->id;

                    // Store Items finance into system.
                    for ($j = 1; $j <= 3; $j++) {
                        if ($request->input('itm-' . $i . '-fc-' . $j) > null &&
                            $request->input('itm-' . $i . '-bl-' . $j) > null &&
                            $request->input('itm-' . $i . '-pr-' . $j) > null) {
                            if ($request->input('itm-' . $i . '-fc-' . $j) > 0 &&
                                $request->input('itm-' . $i . '-bl-' . $j) > 0 &&
                                $request->input('itm-' . $i . '-pr-' . $j) > 0) {

                                MrFinanceItem::insert([
                                    'mr_id' => $movement_request_id,
                                    'item_id' => $item_id,
                                    'fund_code_id' => $request->input('itm-' . $i . '-fc-' . $j),
                                    'budget_line_id' => $request->input('itm-' . $i . '-bl-' . $j),
                                    'percentage' => $request->input('itm-' . $i . '-pr-' . $j),
                                    'created_at' => now()
                                ]);
                            }
                        }
                    }
                    $items_approval = 0;
                }
            }
        } else {
            $items_approval = 4;
        }

        // Variable
        $line_manager_approval = 1;
        $passengers = MrPassengers::select('line_manager_approval')->where('mr_id', $movement_request_id)->get();
        foreach ($passengers as $passenger) {
            if ($passenger->line_manager_approval == 0) {
                $line_manager_approval = 0;
            }
        }
        echo $line_manager_approval;

        $approvals = new MrApproval;

        $approvals->mr_id = $movement_request_id;
        $approvals->line_manager_approval = $line_manager_approval;
        $approvals->items_approval_name = null;
        $approvals->items_approval = $items_approval;
        $approvals->items_approval_reason = null;
        $approvals->items_approval_timestamp = null;
        $approvals->risk_approval_name = null;
        $approvals->risk_approval = 0;
        $approvals->risk_reason = null;
        $approvals->risk_timestamp = null;
        $approvals->country_director_approval_name = null;
        if ($is_outside_krg == 1) {
            $approvals->country_director_approval = 0;
        } else {
            $approvals->country_director_approval = 4;
        }
        $approvals->country_director_reason = null;
        $approvals->country_director_timestamp = null;
        $approvals->created_at = now();

        $approvals->save();

        return redirect()->route('movements.show', $movement_request_id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $access = 0;
        $movement_request = collect(DB::select('SELECT mr.id AS id, mr.name AS name, mr.requester_id AS requester_id, mr.purpose, u.first_name, u.last_name, mr.created_at, mr.updated_at FROM movement_requests mr
            INNER JOIN users u ON mr.requester_id = u.id
            WHERE ( mr.is_delete = 0 AND mr.is_canceled = 0 AND mr.id = ' . $id . ')'))->first();
        $pass = MrPassengers::select('passenger_id')
            ->where('mr_id', $id)
            ->get();

        if ($movement_request->requester_id == Auth::id()) {
            $access = 1;
        }

        foreach ($pass as $_pass) {
            if ($_pass->passenger_id == Auth::id()) {
                $access = 1;
            }
        }

        if ($access == 1) {
            $cd_approval_info = (DB::select('SELECT u.first_name, u.last_name
                                                FROM user_permissions AS up
                                                INNER JOIN users AS u
                                                ON u.id = up.user_id
                                                WHERE(up.value = 1 AND up.permission = "risk_movementRequest_approvals_cd");'))[0];
            $risk_approval_info = (DB::select('SELECT u.first_name, u.last_name
                                                FROM user_permissions AS up
                                                INNER JOIN users AS u
                                                ON u.id = up.user_id
                                                WHERE(up.value = 1 AND up.permission = "risk_movementRequest_approvals_risk");'))[0];
            // Check Movement is exist.
            if ($movement_request == null) {
                return redirect()->route('movements.index');
            } else {
                $passengers = DB::select('SELECT p.passenger_id, u.first_name AS p_first_name, u.last_name  AS p_last_name, sv.first_name AS sv_first_name, sv.last_name AS sv_last_name, p.line_manager_approval, p.line_manager_reason, p.line_manager_timestamp
                                                FROM mr_passengers AS p INNER Join users AS u ON u.id = p.passenger_id INNER Join users AS sv ON sv.id = u.supervisor_id
                                                WHERE (p.mr_id = ' . $id . ' AND p.is_delete = 0);');

                $items = MrItem::select('id', 'description')
                    ->where('mr_id', $id)
                    ->where('is_delete', 0)
                    ->get();
                $itineraries = DB::select('SELECT mi.id, lfrom.name AS from_location, mi.from_date, mi.from_time, lto.name   AS to_location, mi.to_date, mi.to_time FROM mr_itineraries mi
                                                    INNER JOIN locations lfrom ON mi.from_location_id = lfrom.id INNER JOIN locations lto ON mi.to_location_id = lto.id
                                                    WHERE (mi.is_delete = 0 AND mi.mr_id = ' . $id . ')');
                $accommodations = DB::select('SELECT ma.id AS id, ma.user_id AS user_id, ma.check_in, ma.check_out, l.name AS location_name, u.first_name AS first_name, u.last_name AS last_name FROM mr_accommodations AS ma
                                            INNER JOIN users u on ma.user_id = u.id
                                            INNER JOIN locations l on ma.location_id = l.id WHERE ma.mr_id = ' . $id);

                $approvals = MrApproval::select('id', 'items_approval_name', 'items_approval', 'items_approval_reason', 'items_approval_timestamp', 'risk_approval_name', 'risk_approval', 'risk_reason', 'risk_timestamp', 'country_director_approval_name', 'country_director_approval', 'country_director_reason', 'country_director_timestamp')
                    ->where('is_delete', 0)
                    ->firstWhere('mr_id', $id);

                /**
                 * Passneger Finance
                 */
                $passengersFinance = DB::select('SELECT mfp.user_id AS user_id, fc.name AS fund_code, bl.name AS budget_line, percentage FROM mr_finance_passengers mfp
                                                INNER JOIN fund_codes fc on mfp.fund_code_id = fc.id
                                                INNER JOIN budget_lines bl on mfp.budget_line_id = bl.id
                                                WHERE (mfp.is_delete = 0 AND mfp.mr_id = ' . $id . ')');

                /**
                 * Item Finance
                 */
                $itemsFinance = DB::select('SELECT mfi.item_id, fc.name AS fund_code, bl.name AS budget_line, mfi.percentage
                                                    FROM mr_finance_items AS mfi
                                                    INNER JOIN fund_codes fc on mfi.fund_code_id = fc.id
                                                    INNER JOIN budget_lines bl on mfi.budget_line_id = bl.id
                                                    WHERE (mfi.is_delete = 0 AND mfi.mr_id = ' . $id . ')');

                /**
                 * Accommodations Finance
                 */
                $accommodationsFinance = DB::select('SELECT accommodations_id AS id, fc.name AS fund_code, bl.name AS budget_line, percentage
                                                    FROM mr_finance_accommodations mfa
                                                    INNER JOIN fund_codes fc on mfa.fund_code_id = fc.id
                                                    INNER JOIN budget_lines bl on mfa.budget_line_id = bl.id
                                                    WHERE (mr_id = ' . $id . ')');

                return view('users.movements.show', [
                    'active_primary_menu' => 'view',
                    'movement_request' => $movement_request,
                    'passengers' => $passengers,
                    'passengersFinance' => $passengersFinance,
                    'items' => $items,
                    'itemsFinance' => $itemsFinance,
                    'itineraries' => $itineraries,
                    'accommodations' => $accommodations,
                    'accommodationsFinance' => $accommodationsFinance,
                    'approvals' => $approvals,
                    'cd_approval_info' => $cd_approval_info,
                    'risk_approval_info' => $risk_approval_info,
                ]);
            }
        } else {
            return redirect()->route('access-denied');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Show the specified resource from storage to be deleted.
     *
     * @param int $id
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public
    function delete($id)
    {
        $movement_request = MovementRequest::firstWhere('id', $id);
        return view('users.movements.delete', [
            'active_primary_menu' => 'cancel',
            'movement_request' => $movement_request,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        MrPassengers::where('mr_id', $id)
            ->update(['is_delete' => 1]);
        MrFinancePassenger::where('mr_id', $id)
            ->update(['is_delete' => 1]);
        MrItem::where('mr_id', $id)
            ->update(['is_delete' => 1]);
        MrFinanceItem::where('mr_id', $id)
            ->update(['is_delete' => 1]);
        MrItinerary::where('mr_id', $id)->update([
            'is_delete' => 1,
            'updated_at' => now(),
        ]);
        MrAccommodation::where('mr_id', $id)
            ->update(['is_delete' => 1]);
        MrFinanceAccommodation::where('mr_id', $id)
            ->update(['is_delete' => 1]);
        MrApproval::where('mr_id', $id)
            ->update(['is_delete' => 1]);
        MovementRequest::where('id', $id)
            ->update(['is_delete' => 1]);


        return redirect()->route('movements.index');
    }
}
