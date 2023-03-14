<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permission_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
        });

        $userRole = Role::isUser()->first();
        $adminRole = Role::isAdmin()->first();

        $usersPermission = Permission::isUsersPermission()->first();
        $requestsPermission = Permission::isRequestsPermission()->first();
        $employeesPermission = Permission::isEmployeesPermission()->first();
        $companyPermission = Permission::isCompanyPermission()->first();
        $profilePermission = Permission::isProfilePermission()->first();
        $dashboardPermission = Permission::isDashboardPermission()->first();
        $rolesPermission = Permission::isRolesPermission()->first();
        $permissionsPermission = Permission::isPermissionsPermission()->first();

        DB::table('permission_role')->insert([
            [
                'role_id' => $userRole->id,
                'permission_id' => $requestsPermission->id,
            ],
            [
                'role_id' => $userRole->id,
                'permission_id' => $employeesPermission->id,
            ],
            [
                'role_id' => $userRole->id,
                'permission_id' => $profilePermission->id,
            ],
            [
                'role_id' => $userRole->id,
                'permission_id' => $dashboardPermission->id,
            ],
            [
                'role_id' => $adminRole->id,
                'permission_id' => $requestsPermission->id,
            ],
            [
                'role_id' => $adminRole->id,
                'permission_id' => $employeesPermission->id,
            ],
            [
                'role_id' => $adminRole->id,
                'permission_id' => $usersPermission->id,
            ],
            [
                'role_id' => $adminRole->id,
                'permission_id' => $companyPermission->id,
            ],
            [
                'role_id' => $adminRole->id,
                'permission_id' => $profilePermission->id,
            ],
            [
                'role_id' => $adminRole->id,
                'permission_id' => $dashboardPermission->id,
            ],
            [
                'role_id' => $adminRole->id,
                'permission_id' => $rolesPermission->id,
            ],
            [
                'role_id' => $adminRole->id,
                'permission_id' => $permissionsPermission->id,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('permission_role');
    }
};
