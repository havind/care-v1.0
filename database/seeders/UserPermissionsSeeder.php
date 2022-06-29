<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use App\Models\UserPermissions;
use Illuminate\Database\Seeder;

class UserPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::all();
        $users = User::all();

        foreach ($permissions as $permission) {
            foreach ($users as $user) {
                if ($user->id == 1) {
                    $value = 1;
                } else {
                    $value = 0;
                }
                UserPermissions::insert([
                    'user_id' => $user->id,
                    'permission' => $permission->name,
                    'value' => $value,
                    'created_at' => now()
                ]);
            }
        }

        $data = [

        ];
    }
}
