<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ibFunctions;
use App\Models\FundCode;
use Illuminate\Http\Request;

class FundCodeController extends Controller
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
        $fund_codes = FundCode::select()
            ->where('is_delete', 0)
            ->orderBy('name')
            ->paginate(20);

        return view('finance.fund_code.index', [
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
        if (ibFunctions::check_permission('finance_fundCode_create')) {
            return view('finance.fund_code.create');
        } else {
            return redirect()->route('home.access_denied');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (ibFunctions::check_permission('finance_fundCode_create')) {
            $new_fund_code = $request->input('fund-code-name');
            $new_fund_code_description = $request->input('fund-code-description');

            $fund_code_exist = FundCode::firstWhere('name', $new_fund_code);

            if ($fund_code_exist != null) {
                return redirect()->route('fund-codes.create');
            } else {
                FundCode::insert([
                    'name' => $new_fund_code,
                    'description' => $new_fund_code_description,
                    'created_at' => now(),
                ]);

                $latest_fund_code = FundCode::select()
                    ->orderBy('created_at', 'DESC')
                    ->first();

                return redirect()->route('fund-codes.show', $latest_fund_code->id);
            }
        } else {
            return redirect()->route('access-denied');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (ibFunctions::check_permission('finance_fundCode_show')) {
            $fund_code = FundCode::firstWhere('id', $id);
            return view('finance.fund_code.show', [
                'fund_code' => $fund_code,
                'active_primary_menu' => 'view',
            ]);
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
        if (ibFunctions::check_permission('finance_fundCode_edit')) {
            $fund_code = FundCode::firstWhere('id', $id);
            return view('finance.fund_code.edit', [
                'fund_code' => $fund_code,
                'active_primary_menu' => 'edit',
            ]);
        } else {
            return redirect()->route('access-denied');
        }
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
        if (ibFunctions::check_permission('finance_fundCode_edit')) {
            $new_fund_code = $request->input('fund-code-name');
            $new_fund_code_status = $request->input('fund-code-status');
            $new_fund_code_description = $request->input('fund-code-description');

            FundCode::where('id', $id)
                ->update([
                    'name' => $new_fund_code,
                    'is_active' => ($new_fund_code_status === 'on') ? 1:0,
                    'description' => $new_fund_code_description,

                ]);

            return redirect()->route('fund-codes.show', $id);
        } else {
            return redirect()->route('access-denied');
        }
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        if (ibFunctions::check_permission('finance_fundCode_delete')) {
            $fund_code = FundCode::firstWhere('id', $id);
            return view('finance.fund_code.delete', [
                'fund_code' => $fund_code,
                'active_primary_menu' => 'delete',
            ]);
        } else {
            return redirect()->route('access-denied');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (ibFunctions::check_permission('finance_fundCode_delete')) {
            FundCode::where('id', $id)
                ->update([
                    'is_delete' => 1,
                ]);

            return redirect()->route('fund-codes.index');
        } else {
            return redirect()->route('access-denied');
        }
    }
}
