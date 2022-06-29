<?php

namespace App\Http\Controllers\API\Finance;

use App\Http\Controllers\Controller;
use App\Models\BudgetLine;

class BudgetLineAPIController extends Controller
{
    /**
     * Count the items in the table.
     * @return \Illuminate\Http\JsonResponse
     */
    public function count()
    {
        return response()->json([
            'data' => BudgetLine::count(),
        ]);
    }


    /**
     * Get All Budget Lines.
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $budget_lines = BudgetLine::all();

        return response()->json([
            'data' => $budget_lines,
        ]);
    }

    /**
     * Get All Active Budget Lines.
     * @return \Illuminate\Http\JsonResponse
     */
    public function allActive()
    {
        $budget_lines = BudgetLine::where('is_active', 1)
            ->where('is_delete', 0)
            ->get();

        return response()->json([
            'data' => $budget_lines
        ]);
    }

    /**
     * Get All Inactive Budget Lines.
     * @return \Illuminate\Http\JsonResponse
     */
    public function allInactive()
    {
        $budget_lines = BudgetLine::where('is_active', 0)
            ->where('is_delete', 0)
            ->get();

        return response()->json([
            'data' => $budget_lines
        ]);
    }

    /**
     * Get Budget Lines Filtered by Fund Codes.
     * @param $fund_code
     * @return \Illuminate\Http\JsonResponse
     */
    public function budgetLinesFilteredByFundCode($fund_code)
    {
        $budget_lines = BudgetLine::where('is_active', 1)
            ->where('is_delete', false)
            ->where('fund_code_id', $fund_code)
            ->orderBy('name')
            ->get();

        return response()->json([
            'data' => $budget_lines
        ]);
    }
}
