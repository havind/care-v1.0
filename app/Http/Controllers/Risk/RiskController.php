<?php

namespace App\Http\Controllers\Risk;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ibFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiskController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if(ibFunctions::check_permission('risk_index')) {
            return view('risk.index');
        } else {
            return redirect()->route('home.access_denied');
        }
    }
}
