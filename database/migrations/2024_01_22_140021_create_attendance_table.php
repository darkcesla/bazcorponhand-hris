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
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->date('date')->default(now());
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employee')->onDelete('cascade');
            $table->unsignedBigInteger('shift_daily_id')->nullable();
            $table->foreign('shift_daily_id')->references('id')->on('shift_daily')->onDelete('cascade');
            $table->unsignedBigInteger('attendance_location_id');
            $table->foreign('attendance_location_id')->references('id')->on('attendance_location')->onDelete('cascade');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->double('check_in_longitude')->nullable();
            $table->double('check_in_latitude')->nullable();
            $table->double('check_out_longitude')->nullable();
            $table->double('check_out_latitude')->nullable();  
            $table->string('check_in_image')->nullable();
            $table->string('check_out_image')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
