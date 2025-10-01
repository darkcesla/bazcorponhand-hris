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
        Schema::create('overtime', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employee')->onDelete('cascade');
            $table->date('date');
            $table->enum('day_type',['Weekday','Holiday'])->default('Weekday');
            $table->time('start_time');
            $table->time('end_time');
            $table->double('one_point_five')->nullable();
            $table->double('two')->nullable();
            $table->double('three')->nullable();
            $table->double('four')->nullable();
            $table->unsignedBigInteger('overtime_salary_id');
            $table->foreign('overtime_salary_id')->references('id')->on('overtime_salary')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overtime');
    }
};
