<?php

namespace App\Http\Controllers\Risk;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ibFunctions;
use App\Models\{BudgetLine, FundCode, Location, MovementRequest, MrAccommodation, MrApproval, MrFinanceAccommodation, MrFinanceItem, MrFinancePassenger, MrItem, MrItinerary, MrPassengers, User, UserPermissions};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovementRequestController extends Controller
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (ibFunctions::check_permission('risk_movementRequest_all')) {
            if ((!empty($request->input('requester-name')) && $request->input('requester-name') != 0)) {
                $movement_requests = MovementRequest::where('is_delete', 0)
                    ->where('requester_id', $request->input('requester-name'))
                    ->paginate(20);
            } else {
                $movement_requests = MovementRequest::where('is_delete', 0)->paginate(20);
            }
            $users = User::where('is_active', true)->where('is_delete', 0)->get();
            $itinerary = MrItinerary::where('is_delete', 0)->get();
            $locations = Location::where('is_delete', 0)->get();
            $passengers = DB::select('SELECT mp.mr_id, u.first_name, u.last_name
                                            FROM mr_passengers AS mp
                                            INNER JOIN users u on mp.passenger_id = u.id
                                            WHERE mp.is_delete = 0');

            $approvals = MrApproval::where('is_delete', 0)->get();

            return view('risk.movement_request.index', [
                'movement_requests' => $movement_requests,
                'users' => $users,
                'itinerary' => $itinerary,
                'locations' => $locations,
                'passengers' => $passengers,
                'approvals' => $approvals,
                'active_primary_menu' => 'all',
                'requester_name' => $request->input('requester-name'),
            ]);
        } else {
            return redirect()->route('home.access_denied');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        $movement_request = MovementRequest::firstWhere('id', $id);

        // Check Movement is exist.
        if ($movement_request == null) {
            return redirect()->route('movements.index');
        } else {

            $approvals = DB::select('SELECT ma.id, ma.items_approval_name, ma.items_approval, ma.items_approval_reason, ma.items_approval_timestamp, ma.risk_approval_name, IF(ma.risk_approval = 4, null, cd.first_name) AS risk_first_name, IF(ma.risk_approval = 4, null, cd.last_name) AS risk_last_name, ma.risk_approval, ma.risk_reason, ma.risk_timestamp, ma.country_director_approval_name AS cd_name, IF(ma.country_director_approval = 4, null, cd.first_name) AS cd_first_name, IF(ma.country_director_approval = 4, null, cd.last_name) AS cd_last_name, ma.country_director_approval AS cd_approval, ma.country_director_reason AS cd_reason, ma.country_director_timestamp AS cd_timestamp
                FROM mr_approvals ma
                    LEFT JOIN users risk ON ma.risk_approval_name = risk.id
                    LEFT JOIN users cd ON ma.country_director_approval_name = cd.id
                WHERE (ma.mr_id = ' . $id . ' AND ma.is_delete = 0)');

            $itineraries = DB::select('SELECT mi.id, mi.mr_id, mi.from_location_id AS from_location, lfrom.name AS from_name, mi.from_date, mi.from_time, mi.to_location_id AS to_location, lto.name AS to_name, mi.to_date, mi.to_time
                FROM mr_itineraries mi
                    INNER JOIN locations lfrom ON mi.from_location_id = lfrom.id
                    INNER JOIN locations lto ON mi.to_location_id = lto.id
                WHERE (mi.mr_id = ' . $id . ' AND mi.is_delete = 0)');

            $passengers = DB::select('SELECT p.passenger_id, u.first_name, u.last_name, p.line_manager_approval, p.line_manager_reason, p.line_manager_timestamp
                FROM mr_passengers AS p
                    INNER Join users AS u ON u.id = p.passenger_id
                WHERE p.mr_id = ' . $id . ' AND p.is_delete = 0');
            $passengersFinance = DB::select('SELECT mfp.id, mfp.user_id, fc.name AS fund_code, bl.name AS budget_line, mfp.percentage
                FROM mr_finance_passengers mfp
                    INNER JOIN fund_codes fc on mfp.fund_code_id = fc.id
                    INNER JOIN budget_lines bl on mfp.budget_line_id = bl.id
                WHERE (mfp.mr_id = ' . $id . ' AND mfp.is_delete = 0)');

            $items = MrItem::select('id', 'mr_id', 'description')
                ->where('mr_id', $id)
                ->where('is_delete', 0)
                ->get();
            $itemsFinance = DB::select('SELECT mfi.id, mfi.item_id, fc.name AS fund_code, bl.name AS budget_line, mfi.percentage
                FROM mr_finance_items mfi
                    INNER JOIN fund_codes fc on mfi.fund_code_id = fc.id
                    INNER JOIN budget_lines bl on mfi.budget_line_id = bl.id
                WHERE (mfi.mr_id = ' . $id . ' AND mfi.is_delete = 0)');

            $accommodations = DB::select('SELECT ma.id, ma.user_id, u.first_name, u.last_name, ma.check_in, ma.check_out, l.name AS location
                FROM mr_accommodations ma
                    INNER JOIN users u ON ma.user_id = u.id
                    INNER JOIN locations l on ma.location_id = l.id
                WHERE (ma.mr_id = 268 AND ma.is_delete = 0)');
//            dd($accommodations);
            $accommodationsFinance = DB::select('SELECT mfa.id, mfa.accommodations_id, fc.name AS fund_code, bl.name AS budget_line, mfa.percentage
                FROM mr_finance_accommodations mfa
                    INNER JOIN fund_codes fc on mfa.fund_code_id = fc.id
                    INNER JOIN budget_lines bl on mfa.budget_line_id = bl.id
                WHERE (mfa.mr_id = ' . $id . ' AND mfa.is_delete = 0);');


            return view('risk.movement_request.show', [
                'active_primary_menu' => 'view',
                'movement_request' => $movement_request,
                'passengers' => $passengers,
                'passengersFinance' => $passengersFinance,
                'items' => $items,
                'itemsFinance' => $itemsFinance,
                'itineraries' => $itineraries,
                'accommodations' => $accommodations,
                'accommodationsFinance' => $accommodationsFinance,
                'approvals' => $approvals[0],
            ]);
        }
    }

    /**
     * Print
     */
    public function print($id)
    {
        $movement_request = MovementRequest::firstWhere('id', $id);
        $users = User::select('id', 'first_name', 'last_name', 'supervisor_id', 'acting', 'is_active', 'is_delete')
            ->where('is_active', true)
            ->get();
        $passengers = MrPassengers::select('id', 'mr_id', 'passenger_id', 'line_manager_approval', 'line_manager_reason')
            ->where('mr_id', $id)
            ->where('is_delete', 0)
            ->get();

        $items = MrItem::select('id', 'mr_id', 'description')
            ->where('mr_id', $id)
            ->where('is_delete', 0)
            ->get();
        $locations = Location::select('id', 'name', 'is_krg', 'is_available')
            ->where('is_delete', 0)
            ->get();
        $itineraries = MrItinerary::select('id', 'mr_id', 'from_location_id', 'from_date', 'from_time', 'to_location_id', 'to_date', 'to_time')
            ->where('mr_id', $id)
            ->where('is_delete', 0)
            ->get();
        $accommodations = MrAccommodation::select('id', 'mr_id', 'user_id', 'check_in', 'check_out', 'location_id')
            ->where('mr_id', $id)
            ->where('is_delete', 0)
            ->get();
        $approvals = MrApproval::select(
            'id', 'mr_id', 'line_manager_approval', 'risk_approval', 'risk_reason', 'risk_timestamp', 'country_director_approval', 'country_director_reason', 'country_director_timestamp')
            ->where('is_delete', 0)
            ->firstWhere('mr_id', $id);

        $passengersFinance = MrFinancePassenger::select('id', 'mr_id', 'user_id', 'fund_code_id', 'budget_line_id', 'percentage')
            ->where('mr_id', $id)
            ->where('is_delete', false)
            ->get();
        $itemsFinance = MrFinanceItem::select('id', 'mr_id', 'item_id', 'fund_code_id', 'budget_line_id', 'percentage')
            ->where('mr_id', $id)
            ->where('is_delete', false)
            ->get();
        $accommodationsFinance = MrFinanceAccommodation::select('id', 'mr_id', 'accommodations_id', 'fund_code_id', 'budget_line_id', 'percentage')
            ->where('mr_id', $id)
            ->where('is_delete', false)
            ->get();

        $filteredFundCodes = [];
        $filteredBudgetLines = [];

        foreach ($passengersFinance as $item) {
            array_push($filteredFundCodes, FundCode::select('id', 'name')
                ->where('is_active', 1)
                ->where('is_delete', 0)
                ->firstWhere('id', $item->fund_code_id));
            array_push($filteredBudgetLines, BudgetLine::select('id', 'name', 'fund_code_id')
                ->firstWhere('id', $item->budget_line_id));
        }

        return view('risk.movement_request.print', [
            'active_primary_menu' => 'print',
            'movement_request' => $movement_request,
            'users' => $users,
            'passengers' => $passengers,
            'passengersFinance' => $passengersFinance,
            'fundCodes' => $filteredFundCodes,
            'budgetLines' => $filteredBudgetLines,
            'items' => $items,
            'itemsFinance' => $itemsFinance,
            'locations' => $locations,
            'itineraries' => $itineraries,
            'accommodations' => $accommodations,
            'accommodationsFinance' => $accommodationsFinance,
            'approvals' => $approvals,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $movement_request = MovementRequest::select()
            ->firstWhere('id', $id);

        return view('risk.movement_request.delete', [
            'active_primary_menu' => 'delete',
            'movement_request' => $movement_request,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Display a listing of line manager approvals.
     */
    public function approvals()
    {
        $movement_requests = [];
        if (!ibFunctions::check_permission('risk_movementRequest_approvals')) {
            return redirect()->route('home.access_denied');
        } else {
            if (ibFunctions::check_permission('risk_movementRequest_approvals_cd')) {
                $users = User::where('is_active', true)->where('is_delete', false)->get();
                $itinerary = MrItinerary::where('is_delete', false)->get();
                $locations = Location::all();
                $passengers = MrPassengers::where('is_delete', false)->get();
                $approvals = MrApproval::where('is_delete', false)
                    ->where('country_director_approval', 0)
                    ->where('risk_approval', 1)
                    ->where('line_manager_approval', 1)
                    ->get();

                $risk_approvals = MrApproval::where('is_delete', false)
                    ->where('country_director_approval', 0)
                    ->where('line_manager_approval', 0)
                    ->get();

                // Add risk approvals to all Approvals
                $all_approvals = [];
                foreach ($approvals as $approval) {
                    foreach ($risk_approvals as $risk_approval) {
                        array_push($all_approvals, $approval);
                        array_push($all_approvals, $risk_approval);
                    }
                }

                foreach ($risk_approvals as $key => $risk_approval) {
                    foreach ($passengers as $passenger) {
                        if ($risk_approval->mr_id == $passenger->mr_id) {
                            foreach ($users as $user) {
                                if ($passenger->passenger_id == $user->id) {
                                    $user_permissions = UserPermissions::where('user_id', $passenger->passenger_id)->get();
                                    foreach ($user_permissions as $user_permission) {
                                        if ($user_permission->permission == 'risk_movementRequest_approvals_risk') {
                                            if ($user_permission->value == 1) {
                                                array_push($movement_requests, MovementRequest::select('id', 'name', 'requester_id', 'created_at')
                                                    ->firstWhere('id', $risk_approval->mr_id));
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                foreach ($approvals as $key => $approval) {
                    if ($approval->line_manager_approval == true) {
                        $movement_requests[$key] = MovementRequest::select('id', 'name', 'requester_id', 'created_at')
                            ->firstWhere('id', $approval->mr_id);
                    }
                }

                return view('risk.movement_request.approvals', [
                    'movement_requests' => $movement_requests,
                    'users' => $users,
                    'itinerary' => $itinerary,
                    'locations' => $locations,
                    'passengers' => $passengers,
                    'approvals' => $all_approvals,
                    'active_primary_menu' => 'approvals',
                    'approvalLevel' => 'cd',
                ]);
            } // Risk Approval
            elseif (ibFunctions::check_permission('risk_movementRequest_approvals_risk')) {
                $users = User::where('is_active', true)->where('is_delete', false)->get();
                $itinerary = MrItinerary::where('is_delete', false)->get();
                $locations = Location::all();
                $passengers = MrPassengers::where('is_delete', false)->get();
                $approvals = MrApproval::where('is_delete', false)
                    ->where('line_manager_approval', 1)
                    ->where('risk_approval', 0)
                    ->where('country_director_approval', 0)
                    ->get();

                foreach ($approvals as $key => $approval) {
                    if ($approval->line_manager_approval == true) {
                        $movement_requests[$key] = MovementRequest::select('id', 'name', 'requester_id')
                            ->where('is_canceled', false)
                            ->firstWhere('id', $approval->mr_id);
                    }
                }

                return view('risk.movement_request.approvals', [
                    'movement_requests' => $movement_requests,
                    'users' => $users,
                    'itinerary' => $itinerary,
                    'locations' => $locations,
                    'passengers' => $passengers,
                    'approvals' => $approvals,
                    'active_primary_menu' => 'approvals',
                    'approvalLevel' => 'risk',
                ]);
            } // Line manager Approvals
            elseif (ibFunctions::check_permission('risk_movementRequest_approvals_lm')) {
                $users = User::where('is_active', true)->where('is_delete', false)->get();
                $itinerary = MrItinerary::where('is_delete', false)->get();
                $locations = Location::all();
                $passengers = MrPassengers::where('is_delete', false)->get();
                $approvals = MrApproval::select('id', 'mr_id', 'line_manager_approval')
                    ->where('is_delete', false)
                    ->where('country_director_approval', 0)
                    ->where('risk_approval', 0)
                    ->where('line_manager_approval', 0)
                    ->get();

                foreach ($approvals as $key => $approval) {
                    if ($approval->line_manager_approval == 0) {
                        $havePassengers = MrPassengers::where('mr_id', $approval->mr_id)->count();
                        // Check if no passengers
                        if ($havePassengers > 0) {
                            foreach ($passengers as $passenger) {
                                if ($passenger->mr_id == $approval->mr_id) {
                                    $movement_requests[$key] = MovementRequest::firstWhere('id', $approval->mr_id);
                                }
                            }
                        } else {
                            $movement_requests[$key] = MovementRequest::firstWhere('id', $approval->mr_id);
                        }
                    }
                }

                return view('risk.movement_request.approvals', [
                    'movement_requests' => $movement_requests,
                    'users' => $users,
                    'itinerary' => $itinerary,
                    'locations' => $locations,
                    'passengers' => $passengers,
                    'approvals' => $approvals,
                    'active_primary_menu' => 'approvals',
                    'approvalLevel' => 'supervisor',
                ]);
            } else {
                return redirect()->route('home.access_denied');
            }
        }
    }

    /**
     *
     */
    public function approvalShow($id, $approvalLevel)
    {
        $movement_request = MovementRequest::firstWhere('id', $id);
        $users = User::select('id', 'first_name', 'last_name', 'supervisor_id', 'acting', 'is_active', 'is_delete')
            ->where('is_active', true)
            ->get();
        $passengers = MrPassengers::select('id', 'mr_id', 'passenger_id', 'line_manager_denial', 'line_manager_denial_reason')
            ->where('mr_id', $id)
            ->where('is_delete', 0)
            ->get();
        $items = MrItem::select('id', 'mr_id', 'description')
            ->where('mr_id', $id)
            ->where('is_delete', 0)
            ->get();
        $locations = Location::select('id', 'name', 'is_krg', 'is_available')
            ->where('is_active', 1)
            ->where('is_delete', 0)
            ->get();
        $itineraries = MrItinerary::select('id', 'mr_id', 'from_location_id', 'from_date', 'from_time', 'to_location_id', 'to_date', 'to_time')
            ->where('mr_id', $id)
            ->where('is_delete', 0)
            ->get();
        $accommodations = MrAccommodation::select('id', 'mr_id', 'user_id', 'check_in', 'check_out', 'location_id')
            ->where('mr_id', $id)
            ->where('is_delete', 0)
            ->get();
        $passengersFinance = MrFinancePassenger::select('id', 'mr_id', 'user_id', 'fund_code_id', 'budget_line_id', 'percentage')
            ->where('mr_id', $id)
            ->where('is_delete', false)
            ->get();
        $itemsFinance = MrFinanceItem::select('id', 'mr_id', 'item_id', 'fund_code_id', 'budget_line_id', 'percentage')
            ->where('mr_id', $id)
            ->where('is_delete', false)
            ->get();
        $accommodationsFinance = MrFinanceAccommodation::select('id', 'mr_id', 'accommodations_id', 'fund_code_id', 'budget_line_id', 'percentage')
            ->where('mr_id', $id)
            ->where('is_delete', false)
            ->get();

        $filteredFundCodes = [];
        $filteredBudgetLines = [];

        foreach ($passengersFinance as $item) {
            array_push($filteredFundCodes, FundCode::select('id', 'name')
                ->where('is_active', 1)
                ->where('is_delete', 0)
                ->where('is_delete', 0)
                ->firstWhere('id', $item->fund_code_id));
            array_push($filteredBudgetLines, BudgetLine::select('id', 'name', 'fund_code_id')
                ->firstWhere('id', $item->budget_line_id));
        }

        foreach ($itemsFinance as $item) {
            array_push($filteredFundCodes, FundCode::select('id', 'name')
                ->where('is_active', 1)
                ->where('is_delete', 0)
                ->firstWhere('id', $item->fund_code_id));
            array_push($filteredBudgetLines, BudgetLine::select('id', 'name', 'fund_code_id')
                ->firstWhere('id', $item->budget_line_id));
        }

        foreach ($accommodationsFinance as $item) {
            array_push($filteredFundCodes, FundCode::select('id', 'name')
                ->where('is_active', 1)
                ->where('is_delete', 0)
                ->firstWhere('id', $item->fund_code_id));
            array_push($filteredBudgetLines, BudgetLine::select('id', 'name', 'fund_code_id')
                ->firstWhere('id', $item->budget_line_id));
        }

        return view('risk.movement_request.approval_show', [
            'movement_request' => $movement_request,
            'users' => $users,
            'passengers' => $passengers,
            'passengersFinance' => $passengersFinance,
            'fundCodes' => $filteredFundCodes,
            'budgetLines' => $filteredBudgetLines,
            'items' => $items,
            'itemsFinance' => $itemsFinance,
            'locations' => $locations,
            'itineraries' => $itineraries,
            'accommodations' => $accommodations,
            'accommodationsFinance' => $accommodationsFinance,
            'approvalLevel' => $approvalLevel,
        ]);
    }

    /**
     *
     */
    public function approvalStore(Request $request, $id)
    {

        dd(MrApproval::firstWhere('mr_id', $id));
    }

}
