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
        Schema::create('allowance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_payroll_id');
            $table->foreign('employee_payroll_id')->references('id')->on('employee_payroll')->onDelete('cascade');
            $table->unsignedBigInteger('allowance_type_id');
            $table->foreign('allowance_type_id')->references('id')->on('allowance_type')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allowance');
    }
};
