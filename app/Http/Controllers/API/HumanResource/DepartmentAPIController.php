<?php

namespace App\Http\Controllers\API\HumanResource;

use App\Http\Controllers\Controller;
use App\Models\Department;
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
     * @return JsonResponseAlias
     */
    public function all(): JsonResponseAlias
    {
        return response()->json([
            'data' => Department::all(),
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
