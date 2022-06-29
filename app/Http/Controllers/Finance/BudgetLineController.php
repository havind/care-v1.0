<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\BudgetLine;
use App\Models\FundCode;
use Illuminate\Http\Request;

class BudgetLineController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $budget_lines = BudgetLine::select('id', 'name', 'fund_code_id', 'description')
            ->where('is_active', 1)
            ->where('is_delete', 0)
            ->orderBy('fund_code_id')
            ->paginate(150);

        $fund_codes = FundCode::where('is_delete', 0)->get();

        return view('finance.budget_line.index', [
            'budget_lines' => $budget_lines,
            'fund_codes' => $fund_codes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fund_codes = FundCode::where('is_delete', 0)->get();

        return view('finance.budget_line.create', [
            'fund_codes' => $fund_codes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $budget_line = new BudgetLine;

        $budget_line->fund_code_id = $request->input('bl-fund-code');
        $budget_line->name = $request->input('bl-name');
        $budget_line->description = $request->input('bl-description');

        $budget_line->save();

        $budget_line_id = (BudgetLine::select()
            ->latest('created_at')
            ->first())->id;

        return redirect()->route('budget-lines.show', $budget_line_id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $budget_line = BudgetLine::select()
            ->firstWhere('id', $id);

        $fund_code = FundCode::select('id', 'name', 'description', 'is_active')
            ->where('is_delete', 0)
            ->firstWhere('id', $budget_line->fund_code_id);

        return view('finance.budget_line.show', [
            'active_primary_menu' => 'view',
            'budget_line' => $budget_line,
            'fund_code' => $fund_code,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $budget_line = BudgetLine::select('id', 'name', 'fund_code_id', 'description', 'is_active')
            ->firstWhere('id', $id);

        $fund_codes = FundCode::select('id', 'name')
            ->where('is_delete', 0)
            ->get();

        return view('finance.budget_line.edit', [
            'active_primary_menu' => 'edit',
            'budget_line' => $budget_line,
            'fund_codes' => $fund_codes,
        ]);
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


        $budget_line = new BudgetLine;

        $budget_line->where('id', $id);

        if ($request->input('bl_name') != null) {
            $budget_line->name = $request->input('bl_name');
        } else {
            return redirect()->route('budget-lines.edit', $id);
        }

        if ($request->input('bl_fund_code_id') > 0) {
            $budget_line->fund_code_id = $request->input('bl_fund_code_id');
        } else {
            return redirect()->route('budget-lines.edit', $id);
        }

        $budget_line->description = $request->input('bl_description');

        $budget_line->save();

        return redirect()->route('budget-lines.show', $id);
    }

    /**
     * Display the specified resource to be removed.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
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

}
