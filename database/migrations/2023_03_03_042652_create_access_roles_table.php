<?php

use App\Models\AccessRole;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\AcceptHeader;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('access_roles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('access_roles')->insert([
            [
                'title' => AccessRole::ADMIN,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => AccessRole::USER,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('access_roles');
    }
};
