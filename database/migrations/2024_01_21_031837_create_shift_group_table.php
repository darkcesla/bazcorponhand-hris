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
        Schema::create('shift_group', function (Blueprint $table) {
            $table->id();
            $table->string('group_code');
            $table->string('group_name');
            $table->string('overtime_based_on')->nullable();
            $table->integer('total_days');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_group');
    }
};
