<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leave_type', function (Blueprint $table) {
            $table->id();
            $table->string('leave_code');
            $table->string('leave_name');
            $table->integer('eligibility_leave');
            $table->boolean('limit_date')->default(0);
            $table->boolean('deducted_leave')->default(0);
            $table->enum('day_count',['Work Day','Calendar Day'])->default('Work Day');
            $table->enum('leave_day_type',['Full Day','Part of Day', 'Half Day'])->default('Full Day');
            $table->boolean('validate_attendance_status')->default(0);
            $table->boolean('once_in_employment_period')->default(0);
            $table->boolean('once_in_balance_period')->default(0);
            $table->integer('balance_period_limit')->nullable();
            $table->string('leave_period_base_on')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_type');
    }
};
