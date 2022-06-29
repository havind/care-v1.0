<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            BudgetLineSeeder::class,
            DepartmentSeeder::class,
            FundCodeSeeder::class,
            LocationSeeder::class,
            PermissionSeeder::class,
            PositionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            UserPermissionsSeeder::class,
        ]);
    }
}
