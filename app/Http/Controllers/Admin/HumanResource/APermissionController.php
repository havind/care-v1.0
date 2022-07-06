<?php

namespace App\Http\Controllers\Admin\HumanResource;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPermissions;

class APermissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:adm|humanResources|departments|show', ['only' => ['show']]);
        $this->middleware('permission:adm|humanResources|departments|edit|own', ['only' => ['update']]);
        $this->middleware('permission:adm|humanResources|departments|edit|any', ['only' => ['update']]);
    }

    /**
     *
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


        $permissions = UserPermissions::where('user_id', $id)->get(['id', 'permission', 'value']);

        return view('admin.human_resource.users.permissions.show', [
            'navbar_category' => 'human-resources',
            'navbar_active' => 'users',
            'title' => $user->user_first_name . ' ' . $user->user_last_name,
            'content_action_active' => 'permissions',
            'user' => $user,
            'permissions' => $permissions,
        ]);
    }

    /**
     *
     */
    public function update()
    {

    }
}
