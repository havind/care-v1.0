<?php

namespace App\Http\Controllers\API\HumanResource;

use App\Http\Controllers\Controller;
use App\Models\Position;

class PositionAPIController extends Controller
{
    /**
     * @param $department_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function positions($department_id)
    {
        $positions = Position::select()
            ->where('department_id', $department_id)
            ->get();

        return response()->json([
            'data' => $positions,
        ]);
    }
}
