<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [1, 'Acting Livelihoods Program Manager and Partnership Coordinator', 10],
            [2, 'Admin Assistant', 1],
            [3, 'Assistant Country Director-Operations', 1],
            [4, 'Baghdad Office Administrator', 0],
            [5, 'Case Worker', 0],
            [6, 'Country Director', 4],
            [7, 'Driver', 2],
            [8, 'Finance Assistant', 5],
            [9, 'Finance Manager', 5],
            [10, 'Finance Officer', 5],
            [11, 'Gender and Protection Assistant', 9],
            [12, 'Gender and Protection Manager', 9],
            [13, 'Gender and protection Officer', 9],
            [14, 'Head of Programs', 0],
            [15, 'Health Coordinator', 7],
            [16, 'Health Pharmacist / Program Officer', 7],
            [17, 'Health Programme Manager', 7],
            [18, 'HR Assistant', 3],
            [19, 'HR Manager', 3],
            [20, 'Hygiene Promoter', 0],
            [21, 'Hygiene Promotion Team Leader', 0],
            [22, 'IT Administrator', 1],
            [23, 'Logistics and Procurement Officer', 1],
            [24, 'MEAL Assistant', 8],
            [25, 'MEAL Coordinator', 8],
            [26, 'MEAL Officer', 8],
            [27, 'Procurement and Liaison Officer', 1],
            [28, 'Program Assistant', 0],
            [29, 'Program Field Assistant', 0],
            [30, 'Program Quality and Development Manager', 8],
            [31, 'Psychologist', 0],
            [32, 'Risk Management Manager', 2],
            [33, 'Transport and Risk Officer', 2],
            [34, 'WASH Assistant', 6],
            [35, 'WASH Manager', 6],
            [36, 'WASH Officer', 6],
            [37, 'WASH Programme Officer', 6],
            [38, 'WASH Team Leader', 6],
        ];

        foreach ($data as $datum) {
            Position::insert([
                'id' => $datum[0],
                'name' => $datum[1],
                'department_id' => $datum[2],
                'created_at' => now(),
            ]);
        }
    }
}
