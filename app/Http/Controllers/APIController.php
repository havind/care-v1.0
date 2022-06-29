<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\User;

class APIController extends Controller
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserById($id)
    {
        $user = User::select('id', 'first_name', 'last_name', 'username', 'personal_email', 'work_email', 'personal_phone', 'work_phone', 'supervisor_id', 'acting', 'position_id', 'department_id', 'is_active', 'is_delete', 'created_at', 'updated_at')
            ->where('id', $id)
            ->first();
        return response()->json([
            'users' => $user
        ]);
    }

    // Finance


    public function positionByDepartment($department)
    {
        $positions = Position::select('id', 'name')
            ->where('department_id', $department)
            ->where('is_delete', 0)
            ->get();

        return response()->json([
            'positions' => $positions
        ]);
    }

}
