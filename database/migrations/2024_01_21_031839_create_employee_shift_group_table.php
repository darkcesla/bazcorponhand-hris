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
        Schema::create('employee_shift_group', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shift_group_id');
            $table->foreign('shift_group_id')->references('id')->on('shift_group')->onDelete('cascade');
            $table->date('start_shift_date');
            $table->integer('start_shift_daily');
            $table->boolean('always_present')->default(0);
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employee')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_groups');
    }
};
