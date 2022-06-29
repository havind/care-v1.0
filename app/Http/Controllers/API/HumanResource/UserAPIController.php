<?php

namespace App\Http\Controllers\API\HumanResource;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserAPIController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Count the items in the table.
     * @return JsonResponse
     */
    public function count(): JsonResponse
    {
        return response()->json([
            'data' => User::count(),
        ]);
    }

    /**
     * Get All Users.
     * @return JsonResponse
     */
    public function all($paginate = null): JsonResponse
    {
        $users = User::select(
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
            'sp.first_name AS supervisor_first_name',
            'sp.last_name AS supervisor_last_name',
            'users.acting AS acting_id',
            'ac.first_name AS acting_first_name',
            'ac.last_name AS acting_last_name',
            'users.position_id AS position_id',
            'p.name AS position_name',
            'users.department_id AS department_id',
            'd.name AS department_name',
            'users.email_verified_at AS user_email_verified_at',
            'users.is_active AS user_is_active',
            'users.is_delete AS user_is_delete',
            'users.created_at AS user_created_at',
            'users.updated_at AS user_updated_at',
        )
            ->leftJoin('users AS sp', 'sp.id', '=', 'users.supervisor_id')
            ->leftJoin('users AS ac', 'ac.id', '=', 'users.acting')
            ->leftJoin('departments AS d', 'd.id', '=', 'users.department_id')
            ->leftJoin('positions AS p', 'p.id', '=', 'users.position_id')
            ->orderBy('users.first_name', 'ASC')
            ->paginate($paginate);

        return response()->json([
            'data' => $users,
        ]);
    }

    /**
     * Get All Active Budget Lines.
     * @return JsonResponse
     */
    public function allActive(): JsonResponse
    {
        $users = User::where('is_active', 1)
            ->where('is_delete', 0)
            ->orderBy('users.first_name', 'ASC')
            ->get();

        return response()->json([
            'data' => $users,
        ]);
    }

    /**
     * Get All Inactive Budget Lines.
     * @return \Illuminate\Http\JsonResponse
     */
    public function allInactive()
    {
        $users = User::where('is_active', 0)
            ->where('is_delete', 0)
            ->orderBy('users.first_name', 'ASC')
            ->get();

        return response()->json([
            'data' => $users,
        ]);
    }
}
