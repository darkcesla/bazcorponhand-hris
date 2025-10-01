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
        Schema::table('employee_leave_history', function (Blueprint $table) {
            $table->boolean('superior_approval')->default(true)->after('day_count');
            $table->boolean('hr_approval')->default(true)->after('superior_approval');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_leave_history', function (Blueprint $table) {
            $table->dropColumn('superior_approval');
            $table->dropColumn('hr_approval');
        });
    }
};
