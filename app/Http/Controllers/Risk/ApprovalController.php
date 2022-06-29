<?php

namespace App\Http\Controllers\Risk;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ibFunctions;
use App\Models\{Location, MrApproval, MrItem, MrItinerary, MrPassengers, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB};

class ApprovalController extends Controller
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
    public function index()
    {
        /**
         * Line Manager Approval Data
         */
        $itemsApprovals = DB::select('SELECT mr.id AS mr_id FROM mr_approvals ma
            INNER JOIN movement_requests mr ON ma.mr_id = mr.id
            INNER JOIN users u ON mr.requester_id = u.id
            INNER JOIN users sv ON u.supervisor_id = sv.id
            WHERE (ma.is_delete = 0 AND mr.is_delete = 0 AND ma.items_approval = 0 AND sv.id = ' . Auth::id() . ')');
        $passengerApprovals = DB::select('SELECT p.mr_id AS mr_id FROM mr_passengers AS p
            INNER Join users AS u ON u.id = p.passenger_id
            INNER Join users AS sv ON sv.id = u.supervisor_id
            WHERE (p.is_delete = 0 AND sv.id = ' . Auth::id() . ' AND p.line_manager_approval = 0)');
        $unfiltered_mrs = array_merge($itemsApprovals, $passengerApprovals);
        $line_manager_mrs = [];
        foreach ($unfiltered_mrs as $unfiltered_mr) {
            array_push($line_manager_mrs, (int)$unfiltered_mr->mr_id);
        }
        $line_manager_mrs = implode(', ', array_unique($line_manager_mrs));
        if (empty($line_manager_mrs)) {
            $movements_line_manager = null;
            $passengers_line_manager = null;
            $itineraries_line_manager = null;
        } else {
            $movements_line_manager = DB::select('SELECT mr.id, mr.name, mr.requester_id, u.first_name AS requester_first_name, u.last_name AS requester_last_name, u.supervisor_id, mr.created_at
                FROM movement_requests mr INNER JOIN users u ON mr.requester_id = u.id
                INNER JOIN users sv ON u.supervisor_id = sv.id WHERE (mr.is_delete = 0 AND mr.id IN (' . $line_manager_mrs . '))');
            $passengers_line_manager = DB::select('SELECT mp.mr_id, mp.passenger_id, u.first_name AS passenger_first_name, u.last_name AS passenger_last_name FROM mr_passengers mp
                INNER JOIN users u ON mp.passenger_id = u.id
                INNER JOIN users sv ON u.supervisor_id = sv.id
                WHERE (mp.is_delete = 0 AND mp.mr_id IN (' . $line_manager_mrs . '))');
            $itineraries_line_manager = DB::select('SELECT mi.mr_id, lfrom.name AS from_location, lto.name AS to_location FROM mr_itineraries mi
                INNER JOIN locations lfrom ON mi.from_location_id = lfrom.id
                INNER JOIN locations lto ON mi.to_location_id = lto.id
                WHERE (mi.is_delete = 0 AND mi.mr_id IN (' . $line_manager_mrs . '))');
        }

        /**
         * Risk Data
         */
        $risk_approvals = MrApproval::select('mr_id')
            ->where('risk_approval', 0)
            ->where('line_manager_approval', 1)
            ->where('items_approval', '!=', 0)
            ->where('is_delete', 0)
            ->get();
        $risk_mrs = [];
        foreach ($risk_approvals as $approval) {
            array_push($risk_mrs, $approval->mr_id);
        }
        if ($risk_mrs == null) {
            $movements_risk = null;
            $passengers_risk = null;
            $itineraries_risk = null;
        } else {
            $movements_risk = DB::select('SELECT mr.id, mr.name AS name, mr.requester_id, mr.created_at, u.first_name AS requester_first_name, u.last_name AS requester_last_name
                FROM movement_requests mr
                INNER JOIN users u ON mr.requester_id = u.id
                WHERE mr.id IN (' . implode(', ', $risk_mrs) . ')
                ORDER BY created_at ASC');
            $passengers_risk = DB::select('SELECT mp.id, mp.mr_id, mp.passenger_id, u.first_name AS passenger_first_name, u.last_name AS passenger_last_name
                FROM mr_passengers mp
                INNER JOIN users u ON mp.passenger_id = u.id
                WHERE mr_id IN (' . implode(', ', $risk_mrs) . ');');
            $itineraries_risk = DB::select('SELECT mi.mr_id AS mr_id,
                                                        lfrom.name AS from_location,
                                                        mi.from_date AS from_date,
                                                        mi.from_time AS from_time,
                                                        lto.name AS to_location,
                                                        mi.to_date AS to_date,
                                                        mi.to_time AS to_time
                FROM mr_itineraries mi
                INNER JOIN locations lfrom ON mi.from_location_id = lfrom.id
                INNER JOIN locations lto ON mi.to_location_id = lto.id
                WHERE mi.mr_id IN (' . implode(', ', $risk_mrs) . ')');
        }

        /**
         * Country Director Data
         */
        $cd_approvals = MrApproval::select('mr_id')
            ->where('risk_approval', 1)
            ->where('line_manager_approval', 1)
            ->where('items_approval', '!=', 0)
            ->where('country_director_approval', 0)
            ->where('is_delete', 0)
            ->get();
        $cd_mrs = [];
        foreach ($cd_approvals as $approval) {
            array_push($cd_mrs, $approval->mr_id);
        }
        if ($cd_mrs == null) {
            $movements_cd = null;
            $passengers_cd = null;
            $itineraries_cd = null;
        } else {
            $movements_cd = DB::select('SELECT mr.id, mr.name AS name, mr.requester_id, mr.created_at, u.first_name AS requester_first_name, u.last_name AS requester_last_name
                FROM movement_requests mr
                INNER JOIN users u ON mr.requester_id = u.id
                WHERE mr.id IN (' . implode(', ', $cd_mrs) . ')
                ORDER BY created_at ASC');

            $passengers_cd = DB::select('SELECT mp.id, mp.mr_id, mp.passenger_id, u.first_name AS passenger_first_name, u.last_name AS passenger_last_name
                FROM mr_passengers mp
                INNER JOIN users u ON mp.passenger_id = u.id
                WHERE mr_id IN (' . implode(', ', $cd_mrs) . ');');
            $itineraries_cd = DB::select('SELECT mi.mr_id AS mr_id,
                                                        lfrom.name AS from_location,
                                                        mi.from_date AS from_date,
                                                        mi.from_time AS from_time,
                                                        lto.name AS to_location,
                                                        mi.to_date AS to_date,
                                                        mi.to_time AS to_time
                FROM mr_itineraries mi
                INNER JOIN locations lfrom ON mi.from_location_id = lfrom.id
                INNER JOIN locations lto ON mi.to_location_id = lto.id
                WHERE mi.mr_id IN (' . implode(', ', $cd_mrs) . ')');
        }


        return view('risk.movement_request.approvals.index', [
            'movements_line_manager' => $movements_line_manager,
            'passengers_line_manager' => $passengers_line_manager,
            'itineraries_line_manager' => $itineraries_line_manager,

            'movements_risk' => $movements_risk,
            'passengers_risk' => $passengers_risk,
            'itineraries_risk' => $itineraries_risk,

            'movements_cd' => $movements_cd,
            'passengers_cd' => $passengers_cd,
            'itineraries_cd' => $itineraries_cd,

        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($request->query('level') !== null) {
            $level = $request->query('level');
        }

        $movement_request = collect(DB::select('SELECT mr.id, mr.name, mr.requester_id, u.first_name, u.last_name, mr.purpose, mr.created_at
            FROM movement_requests mr
            INNER JOIN users u ON mr.requester_id = u.id
            WHERE (mr.is_canceled = 0 AND mr.is_delete = 0 and mr.id = ' . $id . ')'))->first();

        $itemsApprovals = collect(DB::select('SELECT ma.id, ma.items_approval, ma.items_approval_reason, u.supervisor_id FROM mr_approvals ma
            INNER JOIN movement_requests mr ON ma.mr_id = mr.id
            INNER JOIN users u ON mr.requester_id = u.id
            WHERE ( ma.is_delete = 0 AND mr.is_delete = 0 AND ma.mr_id = ' . $id . ')'))->first();

        $availableApprovals = MrApproval::select('line_manager_approval', 'items_approval')
            ->firstWhere('mr_id', $id);

        $passengersApprovals = DB::select('SELECT p.id AS id, p.passenger_id AS passenger_id, u.first_name AS p_first_name, u.last_name  AS p_last_name, sv.first_name AS sv_first_name, sv.last_name AS sv_last_name, p.line_manager_approval, p.line_manager_reason, p.line_manager_timestamp
                                                FROM mr_passengers AS p INNER Join users AS u ON u.id = p.passenger_id INNER Join users AS sv ON sv.id = u.supervisor_id
                                                WHERE (p.mr_id = ' . $id . ' AND p.is_delete = 0 AND sv.id = ' . Auth::id() . ');');

        /* Movement Information */

        /* Itinerary */
        $itineraries = DB::select('SELECT mi.id, lfrom.name AS from_location, mi.from_date, mi.from_time, lto.name   AS to_location, mi.to_date, mi.to_time FROM mr_itineraries mi
                                                    INNER JOIN locations lfrom ON mi.from_location_id = lfrom.id INNER JOIN locations lto ON mi.to_location_id = lto.id
                                                    WHERE (mi.is_delete = 0 AND mi.mr_id = ' . $id . ')');

        /* Passengers */
        $passengers = DB::select('SELECT mp.id, u.id, u.first_name, u.last_name, mp.line_manager_approval, mp.line_manager_reason, mp.line_manager_timestamp FROM mr_passengers AS mp
                                        INNER JOIN users u on mp.passenger_id = u.id
                                        WHERE (mp.mr_id = ' . $id . ' AND mp.is_delete = 0 AND u.is_delete = 0)');

        /* Accommodations */
        $accommodations = DB::select('SELECT ma.id AS id, ma.user_id AS user_id, ma.check_in, ma.check_out, l.name AS location_name, u.first_name AS first_name, u.last_name AS last_name FROM mr_accommodations AS ma
                                            INNER JOIN users u on ma.user_id = u.id
                                            INNER JOIN locations l on ma.location_id = l.id WHERE ma.mr_id = ' . $id);

        /* Items */
        $items = MrItem::select('id', 'description')->where('mr_id', $id)->where('is_delete', 0)->get();

        /**
         *  Finance
         */
        /* Passneger Finance */
        $passengersFinance = DB::select('SELECT mfp.user_id AS user_id, fc.name AS fund_code, bl.name AS budget_line, percentage FROM mr_finance_passengers mfp
                                                INNER JOIN fund_codes fc on mfp.fund_code_id = fc.id
                                                INNER JOIN budget_lines bl on mfp.budget_line_id = bl.id
                                                WHERE (mfp.is_delete = 0 AND mfp.mr_id = ' . $id . ')');
        /* Accommodations Finance */
        $accommodationsFinance = DB::select('SELECT accommodations_id AS id, fc.name AS fund_code, bl.name AS budget_line, percentage
                                                    FROM mr_finance_accommodations mfa
                                                    INNER JOIN fund_codes fc on mfa.fund_code_id = fc.id
                                                    INNER JOIN budget_lines bl on mfa.budget_line_id = bl.id
                                                    WHERE (mr_id = ' . $id . ')');
        /* Item Finance */
        $itemsFinance = DB::select('SELECT mfi.item_id, fc.name AS fund_code, bl.name AS budget_line, mfi.percentage
                                            FROM mr_finance_items AS mfi
                                            INNER JOIN fund_codes fc on mfi.fund_code_id = fc.id
                                            INNER JOIN budget_lines bl on mfi.budget_line_id = bl.id
                                            WHERE (mfi.is_delete = 0 AND mfi.mr_id = ' . $id . ')');


        return view('risk.movement_request.approvals.show', [
            'level' => $level,
            'availableApprovals' => $availableApprovals,
            'passengersApprovals' => $passengersApprovals,
            'itemsApprovals' => $itemsApprovals,
            'movement_request' => $movement_request,
            'itineraries' => $itineraries,
            'passengers' => $passengers,
            'items' => $items,
            'accommodations' => $accommodations,
            'passengersFinance' => $passengersFinance,
            'accommodationsFinance' => $accommodationsFinance,
            'itemsFinance' => $itemsFinance,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $approvalType = $request->input('approval-type');
        $approvalLevel = $request->input('approval-level');
        $approvalValue = $request->input('approval-value');
        $denialReason = $request->input('denial-reason');
        $passengerId = $request->input('passenger-id');


        switch ($approvalLevel) {
            case 'cd':
                $approval = MrApproval::where('mr_id', $id)->first();
                $approval->country_director_approval = $approvalValue;
                $approval->country_director_approval_name = Auth::id();
                $approval->country_director_timestamp = now();
                if ($approvalValue == 2) {
                    $approval->country_director_reason = $denialReason;
                } else {
                    $approval->country_director_reason = null;
                }
                $approval->save();
                break;
            case 'risk':
                $approval = MrApproval::where('mr_id', $id)->first();
                $approval->risk_approval = $approvalValue;
                $approval->risk_approval_name = Auth::id();
                $approval->risk_timestamp = now();
                if ($approvalValue == 2) {
                    $approval->risk_reason = $denialReason;
                } else {
                    $approval->risk_reason = null;
                }
                $approval->save();
                break;
            case 'lm':
                if ($approvalType == 'items') {
                    if ($approvalValue == 1) {
                        MrApproval::where('mr_id', $id)
                            ->update([
                                'items_approval_name' => Auth::id(),
                                'items_approval' => 1,
                                'items_approval_timestamp' => now(),
                            ]);
                    } elseif ($approvalValue == 2) {
                        MrApproval::where('mr_id', $id)
                            ->update([
                                'items_approval_name' => Auth::id(),
                                'items_approval' => 2,
                                'items_approval_reason' => $denialReason,
                                'items_approval_timestamp' => now(),
                            ]);
                    }

                } elseif
                ($approvalType == 'passengers') {

                    if ($approvalValue == 1) {
                        MrPassengers::where('id', $passengerId)
                            ->update(['line_manager_approval' => $approvalValue,
                                'line_manager_timestamp' => now(),
                                'updated_at' => now(),]);
                        $pendingPassengers = MrPassengers::where('mr_id', $id)->where('line_manager_approval', 0)->count();
                        if ($pendingPassengers == 0) {
                            MrApproval::where('mr_id', $id)
                                ->update(['line_manager_approval' => 1,
                                    'updated_at' => now(),]);
                        }
                    } elseif
                    ($approvalValue == 2) {
                        MrPassengers::where('id', $passengerId)
                            ->update([
                                'line_manager_approval' => $approvalValue,
                                'line_manager_reason' => $denialReason,
                                'line_manager_timestamp' => now(),
                                'updated_at' => now(),
                            ]);
                    }
                }
                break;
        }

        return redirect()->route('approvals.index');
    }

}
