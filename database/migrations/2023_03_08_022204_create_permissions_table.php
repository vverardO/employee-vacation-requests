<?php

use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('route_title');
            $table->string('route_name');
            $table->timestamps();
        });

        DB::table('permissions')->insert([
            [
                'route_title' => Permission::REQUESTS_TITLE,
                'route_name' => Permission::REQUESTS_NAME,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'route_title' => Permission::USERS_TITLE,
                'route_name' => Permission::USERS_NAME,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'route_title' => Permission::EMPLOYEES_TITLE,
                'route_name' => Permission::EMPLOYEES_NAME,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'route_title' => Permission::COMPANY_TITLE,
                'route_name' => Permission::COMPANY_NAME,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'route_title' => Permission::PROFILE_TITLE,
                'route_name' => Permission::PROFILE_NAME,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'route_title' => Permission::DASHBOARD_TITLE,
                'route_name' => Permission::DASHBOARD_NAME,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
