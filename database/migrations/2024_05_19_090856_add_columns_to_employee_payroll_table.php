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
            $table->double('total_allowance')->nullable();
            $table->double('total_deduction')->nullable();
            $table->string('bpjs_ketenagakerjaan')->nullable();
            $table->string('bpjs_kesehatan')->nullable();
            $table->string('insurance')->nullable();
            $table->string('insurance_number')->nullable();
            $table->string('tax_number', 20)->nullable();
            $table->string('tax_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_payroll', function (Blueprint $table) {
            $table->dropColumn('total_allowance');
            $table->dropColumn('total_deduction');
            $table->dropColumn('bpjs_ketenagakerjaan');
            $table->dropColumn('bpjs_kesehatan');
            $table->dropColumn('insurance');
            $table->dropColumn('insurance_number');
            $table->dropColumn('tax_number', 20);
            $table->dropColumn('tax_type');
        });
    }
};
