<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ibFunctions;
use Illuminate\Http\Request;

class AdminController extends Controller
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
        if (!(new ibFunctions)->check_permission('admin_index')) {
            abort(403);
        } else {
            return view('admin.index', [
                'navbar_category' => null,
                'navbar_active' => 'dashboard',
                'title' => 'Dashboard',
            ]);
        }
    }
}
