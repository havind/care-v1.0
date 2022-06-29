<?php

namespace App\Http\Controllers\API\Finance;

use App\Http\Controllers\Controller;
use App\Models\FundCode;
use Illuminate\Http\JsonResponse as JsonResponseAlias;

class FundCodeAPIController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Count the items in the table.
     * @return JsonResponseAlias
     */
    public function count(): JsonResponseAlias
    {
        return response()->json([
            'data' => FundCode::count(),
        ]);
    }

    /**
     * Get All Fund Codes.
     * @return JsonResponseAlias
     */
    public function all(): JsonResponseAlias
    {
        return response()->json([
            'data' => FundCode::all(),
        ]);
    }

    /**
     * Get All Active Budget Lines.
     * @return \Illuminate\Http\JsonResponse
     */
    public function allActive()
    {
        $fund_codes = FundCode::where('is_active', 1)
            ->where('is_delete', 0)
            ->get();

        return response()->json([
            'data' => $fund_codes,
        ]);
    }

    /**
     * Get All Inactive Budget Lines.
     * @return \Illuminate\Http\JsonResponse
     */
    public function allInactive()
    {
        $fund_codes = FundCode::where('is_active', 0)
            ->where('is_delete', 0)
            ->get();

        return response()->json([
            'data' => $fund_codes,
        ]);
    }

}
