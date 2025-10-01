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
        Schema::create('holiday', function (Blueprint $table) {
            $table->id();
            $table->string('holiday_name');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('holiday_type',['Public','Company'])->default('Public');
            $table->string('religion')->nullable();
            $table->string('nationality')->nullable();
            $table->boolean('recur_every_year')->default(0);
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holiday');
    }
};
