<?php

namespace App\Http\Controllers\HumanResource;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ibFunctions;
use App\Models\Department;
use App\Models\Permission;
use App\Models\Position;
use App\Models\User;
use App\Models\UserPermissions;
use Illuminate\Http\Request;

class StaffController extends Controller
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
        if (ibFunctions::check_permission('humanResource_staff_index')) {
            $staff = User::select('id', 'first_name', 'last_name', 'personal_email', 'work_email', 'personal_phone', 'work_phone', 'supervisor_id', 'acting', 'position_id', 'department_id')
                ->where('is_active', 1)
                ->where('is_delete', 0)
                ->orderBy('first_name')
                ->paginate(20);
            $departments = Department::select('id', 'name')->get();
            $positions = Position::select('id', 'name', 'department_id')->get();

            return view('human_resource.staff.index', [
                'staff' => $staff,
                'departments' => $departments,
                'positions' => $positions,
            ]);
        } else {
            return redirect()->route('access-denied');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::where('is_delete', false)
            ->orderBy('name')
            ->get();

        $users = User::select('id', 'first_name', 'last_name')
            ->orderBy('first_name')
            ->where('is_active', 1)
            ->where('is_delete', 0)
            ->get();

        return view('human_resource.staff.create', [
            'departments' => $departments,
            'users' => $users,
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
        $username = User::where('username', $request->input('username'))->first();

        if ($username == null) {
            $generated_password = chr(rand(65, 90)) . chr(rand(48, 57)) . chr(rand(65, 90)) . '-' . chr(rand(65, 90)) . chr(rand(48, 57)) . chr(rand(65, 90));
            $user = new User;
            $user->first_name = $request->input('first-name');
            $user->last_name = $request->input('last-name');
            $user->username = $request->input('username');
            $user->role_id = 0;
            $user->personal_email = $request->input('personal-email');
            $user->work_email = $request->input('work-email');
            $user->personal_phone = $request->input('personal-phone');
            $user->work_phone = $request->input('work-phone');
            $user->supervisor_id = ($request->input('supervisor') == null) ? 0 : $request->input('supervisor');
            $user->position_id = ($request->input('positions') == null) ? 0 : $request->input('positions');
            $user->department_id = ($request->input('departments') == null) ? 0 : $request->input('departments');
            $user->password = bcrypt($generated_password);
            $user->is_active = 0;
            $user->save();

            $permissions = Permission::all();

            foreach ($permissions as $permission) {
                UserPermissions::insert([
                    'user_id' => $user->id,
                    'permission' => $permission->name,
                    'value' => 0,
                    'created_at' => now()
                ]);
            }

            $request->session()->flash('password', $generated_password);
//            return redirect()->route('staff.show', $users->id);
        } else {
            return redirect()->back()->with('userExists', 'The users is already exists in the system.');
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
        $user = User::select('id', 'first_name', 'last_name', 'username', 'personal_email', 'work_email', 'personal_phone', 'work_phone', 'supervisor_id', 'acting', 'position_id', 'department_id', 'is_active', 'created_at', 'updated_at')
            ->where('is_delete', 0)
            ->firstWhere('id', $id);

        if ($user->supervisor_id == 0) {
            $supervisor = 0;
        } else {
            $supervisor = User::select('id', 'first_name', 'last_name')
                ->firstWhere('id', $user->supervisor_id);
        }

        $acting_supervisor = User::select('id', 'first_name', 'last_name')
            ->firstWhere('id', $user->acting);

        $position = Position::select('id', 'name', 'department_id')
            ->where('is_delete', 0)
            ->firstWhere('id', $user->position_id);

        $department = Department::select('id', 'name')
            ->where('is_delete', 0)
            ->firstWhere('id', $user->department_id);

        return view('human_resource.staff.show', [
            'users' => $user,
            'positions' => $position,
            'departments' => $department,
            'supervisor' => $supervisor,
            'acting_supervisor' => $acting_supervisor,
            'active_primary_menu' => 'view',
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
        if (ibFunctions::check_permission('humanResource_staff_edit')) {
            $user = User::select('id', 'first_name', 'last_name', 'username', 'personal_email', 'work_email', 'personal_phone', 'work_phone', 'supervisor_id', 'acting', 'position_id', 'department_id', 'is_active', 'created_at', 'updated_at')
                ->where('is_delete', 0)
                ->firstWhere('id', $id);

            $users = User::select('id', 'first_name', 'last_name')
                ->where('is_delete', 0)
                ->orderBy('first_name')
                ->get();

            $positions = Position::select('id', 'name', 'department_id')
                ->orderBy('name')
                ->where('is_delete', 0)
                ->get();

            $departments = Department::select('id', 'name')
                ->orderBy('name')
                ->where('is_delete', 0)
                ->get();


            return view('human_resource.staff.edit', [
                'users' => $user,
                'positions' => $positions,
                'departments' => $departments,
                'users' => $users,
                'active_primary_menu' => 'edit',
            ]);
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
        $user = User::firstWhere('id', $id);
        return view('human_resource.staff.delete', [
            'users' => $user,
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
        User::where('id', $id)
            ->update([
                'is_active' => 0,
            ]);

        return redirect()->route('staff.index');
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
        if ($request->input('work-email') != 'Not Available') {
            $work_email = $request->input('work-email');
        } else {
            $work_email = null;
        }

        if ($request->input('personal-email') != 'Not Available') {
            $personal_email = $request->input('personal-email');
        } else {
            $personal_email = null;
        }

        if (substr($request->input('work-phone'), 1) != 'Not Available') {
            if ($request->input('work-phone') == null) {
                $work_phone = null;
            } else {
                $work_phone = $request->input('work-phone');
            }
        } else {
            $work_phone = null;
        }

        if (substr($request->input('personal-phone'), 1) != 'Not Available') {
            if ($request->input('personal-phone') == null) {
                $personal_phone = null;
            } else {
                $personal_phone = $request->input('personal-phone');
            }
        } else {
            $personal_phone = null;
        }

        $staff = User::find($id);

        $staff->first_name = $request->input('first-name');

        $staff->last_name = $request->input('last-name');
        $staff->position_id = $request->input('positions-id');
        $staff->department_id = $request->input('departments-id');
        $staff->supervisor_id = $request->input('supervisor-id');
        $staff->work_email = $work_email;
        $staff->work_phone = $work_phone;
        $staff->personal_email = $personal_email;
        $staff->personal_phone = $personal_phone;

        $staff->save();

        return redirect()->route('staff.show', $id);
    }
}
