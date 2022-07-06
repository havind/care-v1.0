<?php

namespace App\Http\Controllers\API\HumanResource;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\JsonResponse as JsonResponseAlias;

class DepartmentAPIController extends Controller
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
     * @return JsonResponseAlias
     */
    public function count(): JsonResponseAlias
    {
        return response()->json([
            'data' => Department::count(),
        ]);
    }

    /**
     * Get All Users.
     * @return
     */
    public function all($paginate = null)
    {
        $departments = Department::select(
            'departments.id AS department_id',
            'departments.name AS department_title',
            'departments.supervisor_id AS supervisor_id',
            'sp.first_name AS supervisor_first_name',
            'sp.last_name AS supervisor_last_name',
        )
            ->leftJoin('users AS sp', 'sp.id', '=', 'departments.supervisor_id')
            ->paginate($paginate);

        return response()->json([
            'data' => $departments,
        ]);
    }

    /**
     * Get All Active Budget Lines.
     * @return JsonResponseAlias
     */
    public function allActive(): JsonResponseAlias
    {
        $departments = Department::where('is_active', 1)
            ->where('is_delete', 0)
            ->get();

        return response()->json([
            'data' => $departments,
        ]);
    }

    /**
     * Get All Inactive Budget Lines.
     * @return JsonResponseAlias
     */
    public function allInactive()
    {
        $departments = Department::where('is_active', 0)
            ->where('is_delete', 0)
            ->get();

        return response()->json([
            'data' => $departments,
        ]);
    }
}
