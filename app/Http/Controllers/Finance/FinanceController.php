<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ibFunctions;
use Illuminate\Http\Request;

class FinanceController extends Controller
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
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if (ibFunctions::check_permission('finance_index')) {
            return view('finance.index');
        } else {
            return redirect()->route('home.access_denied');
        }
    }
}
