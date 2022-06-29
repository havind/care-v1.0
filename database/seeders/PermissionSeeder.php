<?php

namespace Database\Seeders;

use App\Models\Permission;

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            /**
             * admin
             */
            'admin_index',
            // departments
            'admin_department_index',
            'admin_department_create',
            'admin_department_show',
            'admin_department_edit',
            'admin_department_delete',
            // positions
            'admin_position_index',
            'admin_position_create',
            'admin_position_show',
            'admin_position_edit',
            'admin_position_delete',
            // users
            'admin_user_index',
            'admin_user_create',
            'admin_user_show',
            'admin_user_edit',
            'admin_user_delete',
            'admin_user_permissions',

            /**
             * Risk
             */
            'risk_index',
            'risk_movementRequest_index',
            'risk_movementRequest_create',
            'risk_movementRequest_show',
            'risk_movementRequest_edit',
            'risk_movementRequest_delete',
            'risk_movementRequest_all',
            'risk_movementRequest_approvals',
            // Locations
            'risk_location_index',
            'risk_location_create',
            'risk_location_show',
            'risk_location_edit',
            'risk_location_delete',
            // Approvals
            'risk_movementRequest_approvals_cd',
            'risk_movementRequest_approvals_risk',
            'risk_movementRequest_approvals_lm',

            /**
             * Risk
             * Fleet
             */
            // Fleet
            'risk_fleet_index',
            // Cars
            'risk_fleet_car_index',
            'risk_fleet_car_create',
            'risk_fleet_car_show',
            'risk_fleet_car_edit',
            'risk_fleet_car_delete',

            /**
             * Finance
             */
            'finance_index',
            // Fund Code
            'finance_fundCode_index',
            'finance_fundCode_create',
            'finance_fundCode_show',
            'finance_fundCode_edit',
            'finance_fundCode_delete',
            // Budget Line
            'finance_budgetLine_index',
            'finance_budgetLine_create',
            'finance_budgetLine_show',
            'finance_budgetLine_edit',
            'finance_budgetLine_delete',

            /**
             * Human Resources
             */
            'humanResource_index',

            // Staff
            'humanResource_staff_index',
            'humanResource_staff_create',
            'humanResource_staff_show',
            'humanResource_staff_edit',
            'humanResource_staff_delete',
            // Department
            'humanResource_department_index',
            'humanResource_department_create',
            'humanResource_department_show',
            'humanResource_department_edit',
            'humanResource_department_delete',
        ];

        foreach ($data as $d) {
            Permission::insert([
                'name' => $d,
                'created_at' => now(),
            ]);
        }


    }
}
