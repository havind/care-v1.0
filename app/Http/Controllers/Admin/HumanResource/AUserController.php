<?php

namespace App\Http\Controllers\Admin\HumanResource;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ibFunctions;
use App\Models\Department;
use App\Models\Permission;
use App\Models\Position;
use App\Models\User;
use App\Models\UserPermissions;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AUserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:adm|humanResources|users|index', ['only' => 'index']);
        $this->middleware('permission:adm|humanResources|users|create', ['only' => ['create', 'store']]);
        $this->middleware('permission:adm|humanResources|users|edit|any', ['only' => ['edit', 'update']]);
        $this->middleware('permission:adm|humanResources|users|edit|own', ['only' => ['edit', 'update']]);
        $this->middleware('permission:adm|humanResources|users|delete|own', ['only' => ['delete', 'destroy']]);
        $this->middleware('permission:adm|humanResources|users|delete|any', ['only' => ['delete', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::select('id', 'first_name', 'last_name', 'personal_email', 'work_email', 'personal_phone', 'work_phone', 'supervisor_id', 'acting', 'position_id', 'department_id')
            ->orderBy('first_name')
            ->paginate(20);

        $departments = Department::select('id', 'name')->get();

        $positions = Position::select('id', 'name', 'department_id')->get();

        return view('admin.human_resource.users.index', [
            'navbar_category' => 'human-resources',
            'navbar_active' => 'users',
            'title' => 'Users',
            'users' => $users,
            'departments' => $departments,
            'positions' => $positions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::where('is_delete', 0)
            ->get();

        $positions = Position::where('is_delete', 0)
            ->get();
        return view('admin.human_resource.users.create', [
            'navbar_category' => 'human-resources',
            'navbar_active' => 'users',
            'title' => 'New User',
            'departments' => $departments,
            'positions' => $positions,
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::select(
            'users.id AS user_id',
            'users.first_name AS user_first_name',
            'users.last_name AS user_last_name',
            'users.username AS user_username',
            'users.role_id AS user_role_id',
            'users.personal_email AS user_personal_email',
            'users.work_email AS user_work_email',
            'users.personal_phone AS user_personal_phone',
            'users.work_phone AS user_work_phone',
            'users.supervisor_id AS supervisor_id',
            'sv.first_name AS supervisor_first_name',
            'sv.last_name AS supervisor_last_name',
            'users.acting AS user_acting',
            'users.department_id AS department_id',
            'd.name AS department_title',
            'users.position_id AS position_id',
            'p.name AS position_title',
            'users.created_at AS user_created_at',
            'users.updated_at AS user_updated_at',

        )
            ->leftJoin('users AS sv', 'sv.id', '=', 'users.supervisor_id')
            ->leftJoin('departments AS d', 'd.id', '=', 'users.department_id')
            ->leftJoin('positions AS p', 'p.id', '=', 'users.position_id')
            ->firstWhere('users.id', $id);

        return view('admin.human_resource.users.show', [
            'navbar_category' => 'human-resources',
            'navbar_active' => 'users',
            'title' => $user->user_first_name . ' ' . $user->user_last_name,
            'content_action_active' => 'view',
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::select(
            'users.id AS user_id',
            'users.first_name AS user_first_name',
            'users.last_name AS user_last_name',
            'users.username AS user_username',
            'users.role_id AS user_role_id',
            'users.personal_email AS user_personal_email',
            'users.work_email AS user_work_email',
            'users.personal_phone AS user_personal_phone',
            'users.work_phone AS user_work_phone',
            'users.supervisor_id AS supervisor_id',
            'sv.first_name AS supervisor_first_name',
            'sv.last_name AS supervisor_last_name',
            'users.acting AS user_acting',
            'users.department_id AS department_id',
            'd.name AS department_title',
            'users.position_id AS position_id',
            'p.name AS position_title',
            'users.created_at AS user_created_at',
            'users.updated_at AS user_updated_at',

        )
            ->leftJoin('users AS sv', 'sv.id', '=', 'users.supervisor_id')
            ->leftJoin('departments AS d', 'd.id', '=', 'users.department_id')
            ->leftJoin('positions AS p', 'p.id', '=', 'users.position_id')
            ->firstWhere('users.id', $id);

        return view('admin.human_resource.users.edit', [
            'navbar_category' => 'human-resources',
            'navbar_active' => 'users',
            'title' => 'Edit ' . $user->user_first_name . ' ' . $user->user_last_name,
            'content_action_active' => 'edit',
            'user' => $user,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function delete($id)
    {
        $user = User::firstWhere('id', $id);

        return view('admin.human_resource.users.delete', [
            'navbar_category' => 'human-resources',
            'navbar_active' => 'users',
            'profile' => $user,
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
        //
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
        $validated = $request->validate([
            'user-first-name' => 'required|string',
            'user-last-name' => 'required|string',
            'user-username' => 'required|string',
            'user-department' => 'required|numeric',
            'user-position' => 'required|numeric',
            'user-supervisor' => 'required|numeric',
            'user-work-email' => 'email',
            'user-work-phone' => 'string',
            'user-personal-email' => 'email',
            'user-personal-phone' => 'string',
        ]);

        dd($validated);

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
        $staff->department_id = $request->input('department-id');
        $staff->supervisor_id = $request->input('supervisor-id');
        $staff->work_email = $work_email;
        $staff->work_phone = $work_phone;
        $staff->personal_email = $personal_email;
        $staff->personal_phone = $personal_phone;

        $staff->save();

        return redirect()->route('a.users.show', $id);
    }

    /**
     *
     */
    public function reset_password($id)
    {
        $profile = User::select('id', 'first_name', 'last_name')
            ->firstWhere('id', $id);

        return view('admin.human_resource.users.reset_password', [
            'profile' => $profile,
            'active_primary_menu' => 'reset-password',
        ]);
    }

    /**
     *
     */
    public function update_password(Request $request, $id)
    {
        User::where('id', $id)
            ->update([
                'password' => bcrypt($request->input('reset-password')),
            ]);
        return redirect()->route('a.users.show', $id);
    }
}

/**
 * Display a listing of the resource.
 *
 * @return Application|Factory|View|\Illuminate\Http\Response
 */
public function permissions($id)
{
    if (ibFunctions::check_permission('admin_User_permissions')) {

    } else {

    }
    $user = User::firstWhere('id', $id);
    $permissions = Permission::where('is_delete', false)->get();
    $user_permissions = UserPermissions::where('user_id', $id)->get(['id', 'permission', 'value']);

    return view('admin.human_resource.users.permissions', [
        'profile' => $user,
        'permissions' => $permissions,
        'user_permissions' => $user_permissions,
        'active_primary_menu' => 'permissions',
    ]);
}

/**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
public function update_permissions(Request $request, $id)
{
    $user_permissions = UserPermissions::where('user_id', $id)->get();

    foreach ($user_permissions as $user_permission) {
        if ($request->input($user_permission->permission) == null) {
            $value = false;
        } else {
            $value = true;
        }

        UserPermissions::where('user_id', $id)
            ->where('permission', $user_permission->permission)
            ->update([
                'value' => $value,
                'updated_at' => now(),
            ]);
    }
    return redirect()->route('a.users.permissions', $id);
}
