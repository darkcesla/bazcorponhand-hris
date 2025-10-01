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
        Schema::create('shift_group_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('day_order');
            $table->unsignedBigInteger('shift_group_id');
            $table->foreign('shift_group_id')->references('id')->on('shift_group')->onDelete('cascade');
            $table->unsignedBigInteger('shift_daily_id');
            $table->foreign('shift_daily_id')->references('id')->on('shift_daily')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_group_detail');
    }
};
