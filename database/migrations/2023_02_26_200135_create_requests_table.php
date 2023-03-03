<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->string('title', 128);
            $table->date('start');
            $table->date('end');
            $table->timestamp('approved_at')->nullable()->default(null);
            $table->timestamp('rejected_at')->nullable()->default(null);
            $table->enum('status', ['opened', 'approved', 'rejected']);
            $table->foreignId('company_id')->constrained();
            $table->foreignId('employee_id')->constrained();
            $table->foreignId('request_type_id')->constrained();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('approved_by')->nullable()->default(null);
            $table->unsignedBigInteger('rejected_by')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('approved_by')->references('id')->on('users');
            $table->foreign('rejected_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
