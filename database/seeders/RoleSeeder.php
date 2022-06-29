<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'movement_request_approval_risk',
            'movement_request_approval_cd'
        ];

        foreach ($data as $d) {
            Role::insert([
                'name' => $d,
                'created_at' => now(),
            ]);
        }
    }
}
