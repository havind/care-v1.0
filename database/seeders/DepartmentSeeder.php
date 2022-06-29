<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [1, 'Operations', 6],
            [2, 'Risk', 2],
            [3, 'Human Resources', 7],
            [4, 'Country Director', 4],
            [5, 'Finance', 8],
            [6, 'WASH', 9],
            [7, 'Health', 0],
            [8, 'MEAL', 0],
            [9, 'Gender and Protection', 10],

        ];

        foreach ($data as $datum) {
            Department::insert([
                'id' => $datum[0],
                'name' => $datum[1],
                'supervisor_id' => $datum[2],
                'created_at' => now(),
            ]);
        }
    }
}
