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
        Schema::table('employee_payroll', function (Blueprint $table) {
            // Remove existing allowance fields
            $table->dropColumn([
                'positional_allowance',
                'skill_allowance',
                'hazard_allowance',
                'remote_allowance',
                'attendance_allowance',
                'meal_allowance',
                'transport_allowance',
                'entertaint_allowance',
                'compensation_allowance',
                'festivity_allowance',
                'site_allowance',
                'tax_allowance'
            ]);

            // Add a new 'allowance' field as a JSON column
            $table->json('allowance')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_payroll', function (Blueprint $table) {
            // Reverse the modifications: add back the removed columns
            $table->double('positional_allowance')->nullable();
            $table->double('skill_allowance')->nullable();
            $table->double('hazard_allowance')->nullable();
            $table->double('remote_allowance')->nullable();
            $table->double('attendance_allowance')->nullable();
            $table->double('meal_allowance')->nullable();
            $table->double('transport_allowance')->nullable();
            $table->double('entertaint_allowance')->nullable();
            $table->double('compensation_allowance')->nullable();
            $table->double('festivity_allowance')->nullable();
            $table->double('site_allowance')->nullable();
            $table->double('tax_allowance')->nullable();

            // Remove the 'allowance' JSON column
            $table->dropColumn('allowance');
        });
    }
};
