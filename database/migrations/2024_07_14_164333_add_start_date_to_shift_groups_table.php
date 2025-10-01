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
        Schema::table('shift_group', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('total_days'); // Adjust 'existing_column' to the column after which you want to add 'start_date'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shift_group', function (Blueprint $table) {
            $table->dropColumn('start_date');
        });
    }
};
