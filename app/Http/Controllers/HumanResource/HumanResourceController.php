<?php

namespace App\Http\Controllers\HumanResource;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ibFunctions;
use Illuminate\Http\Request;

class HumanResourceController extends Controller
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
        if (ibFunctions::check_permission('humanResource_index')) {
            return view('human_resource.index');
        } else {
            return redirect()->route('home.access_denied');
        }
    }
}
