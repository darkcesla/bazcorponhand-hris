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
        Schema::create('shift_daily', function (Blueprint $table) {
            $table->id();
            $table->string('shift_daily_code');
            $table->string('day_type');
            $table->string('shift_daily_code_ph')->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('grace_for_late');
            $table->integer('productive_work_time');
            $table->time('break_start')->nullable();
            $table->time('break_end')->nullable();
            $table->string('remark')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_daily');
    }
};
