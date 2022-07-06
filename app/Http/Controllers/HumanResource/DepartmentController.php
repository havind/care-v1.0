<?php

namespace App\Http\Controllers\HumanResource;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ibFunctions;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
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
        if (!ibFunctions::check_permission('humanResource_department_index')) {
            return redirect()->route('home.access_denied');
        } else {
            $departments = Department::where('is_delete', false)->get();
            $users = User::all();
            $supervisors = [];
            $i = 0;
            foreach ($departments as $department) {
                foreach ($users as $user) {
                    if ($department->supervisor_id == $user->id) {
                        $supervisors[$i++] = $user;
                    }
                }
            }

            return view('human_resource.departments.index', [
                'departments' => $departments,
                'supervisors' => $supervisors,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!ibFunctions::check_permission('humanResource_department_create')) {
            return redirect()->route('home.access_denied');
        } else {
            $users = User::select('id', 'first_name', 'last_name')
                ->orderBy('first_name')
                ->where('is_delete', 0)
                ->get();
            return view('human_resource.departments.create', [
                'users' => $users,
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!ibFunctions::check_permission('humanResource_department_create')) {
            return redirect()->route('access_denied');
        } else {
            if (Department::where('name', $request->input('departments-name'))->count() != 0) {
                return redirect()->route('departments.create');
            } else {
                Department::insert([
                    'name' => $request->input('departments-name'),
                    'supervisor_id' => $request->input('departments-supervisor'),
                    'description' => $request->input('departments-description'),
                    'created_at' => now(),
                ]);

                return redirect()->route('departments.show', Department::get()->last()->id);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        if (ibFunctions::check_permission('humanResource_department_show')) {
            $department = Department::where('id', $id)
                ->where('is_delete', false)
                ->firstOrFail();

            $supervisor = User::where('id', $department->supervisor_id)
                ->get(['id', 'first_name', 'last_name'])->first();
            if ($supervisor == null) {
                $supervisor = null;
            }

            return view('human_resource.departments.show', [
                'departments' => $department,
                'supervisor' => $supervisor,
                'active_primary_menu' => 'view',
            ]);
        } else {
            return redirect()->route('access_denied');
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
        $department = Department::where('id', $id)
            ->where('is_delete', false)
            ->firstOrFail();

        $users = User::where('is_delete', false)
            ->orderBy('first_name')
            ->get(['id', 'first_name', 'last_name']);

        return view('human_resource.departments.edit', [
            'departments' => $department,
            'users' => $users,
            'active_primary_menu' => 'edit',
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
        Department::where('id', $id)
            ->where('is_delete', false)
            ->update([
                'name' => $request->input('dept-name'),
                'supervisor_id' => $request->input('dept-supervisor'),
                'description' => $request->input('dept-description'),
                'updated_at' => now(),
            ]);

        return redirect()->route('departments.show', $id);
    }

    /**
     * Display the specified resource to be deleted from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $department = Department::firstWhere('id', $id);
        return view('human_resource.departments.delete', [
            'departments' => $department,
            'active_primary_menu' => 'delete',
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
        $department = Department::find($id);
        $department->is_delete = 1;
        $department->save();

        return redirect()->route('departments.index');
    }

    /**
     * Display a listing of staff by departments.
     *
     * @return \Illuminate\Http\Response
     */
    public function departmentStaff($id)
    {
        $department = Department::select('id', 'name')
            ->where('id', $id)
            ->firstOrFail();

        $staff = User::where('is_delete', false)
            ->where('department_id', $id)
            ->orderBy('first_name', 'ASC')
            ->get(['id', 'first_name', 'last_name', 'work_email', 'work_phone', 'position_id', 'is_active']);

        $positions = Position::select('id', 'name')
            ->where('department_id', $id)
            ->get();

        return view('human_resource.departments.staff.index', [
            'departments' => $department,
            'staff' => $staff,
            'positions' => $positions,
            'active_primary_menu' => 'staff',
        ]);
    }

    /**
     *
     */
    public function departmentNewStaff($id)
    {
        $department = Department::select('id', 'name')
            ->where('id', $id)
            ->firstOrFail();

        $departments = Department::select('id', 'name')
            ->get();

//        dd($departments);
        return view('human_resource.departments.staff.create', [
            'departments' => $department,
            'departments' => $departments,
        ]);
    }
}
