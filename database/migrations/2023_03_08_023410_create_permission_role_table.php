<?php

use App\Models\Permission;
use App\Models\Role;
use Carbon\Carbon;
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
            $table->timestamps();
        });

        $userRole = Role::isUser()->first();
        $adminRole = Role::isAdmin()->first();

        $usersPermission = Permission::isUsersPermission()->first();
        $requestsPermission = Permission::isRequestsPermission()->first();
        $employeesPermission = Permission::isEmployeesPermission()->first();
        $companyPermission = Permission::isCompanyPermission()->first();
        $profilePermission = Permission::isProfilePermission()->first();
        $dashboardPermission = Permission::isDashboardPermission()->first();

        DB::table('permission_role')->insert([
            [
                'role_id' => $userRole->id,
                'permission_id' => $requestsPermission->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'role_id' => $userRole->id,
                'permission_id' => $employeesPermission->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'role_id' => $userRole->id,
                'permission_id' => $profilePermission->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'role_id' => $userRole->id,
                'permission_id' => $dashboardPermission->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'role_id' => $adminRole->id,
                'permission_id' => $requestsPermission->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'role_id' => $adminRole->id,
                'permission_id' => $employeesPermission->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'role_id' => $adminRole->id,
                'permission_id' => $usersPermission->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'role_id' => $adminRole->id,
                'permission_id' => $companyPermission->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'role_id' => $adminRole->id,
                'permission_id' => $profilePermission->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'role_id' => $adminRole->id,
                'permission_id' => $dashboardPermission->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('permission_role');
    }
};
