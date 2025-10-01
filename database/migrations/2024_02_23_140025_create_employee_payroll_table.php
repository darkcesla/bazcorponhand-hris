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
        Schema::create('employee_payroll', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employee')->onDelete('cascade');
            $table->date('effective_salary_date');
            $table->string('title');
            $table->boolean('tax_flag');
            $table->enum('salary_received',['Gross','Net','Gross On Top'])->default('Gross');
            $table->string('pay_frequency');
            $table->double('basic_salary');
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
            $table->double('bonus')->nullable();           
            $table->date('end_date');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_payroll');
    }
};
