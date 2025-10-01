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
        Schema::table('overtime', function (Blueprint $table) {
            $table->renameColumn('overtime_salary_id', 'salary_per_hour');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('overtime', function (Blueprint $table) {
            // Revert the column name back to its original
            $table->renameColumn('salary_per_hour', 'overtime_salary_id');
        });
    }
};
