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
        Schema::table('employee_career', function (Blueprint $table) {
            $table->date('join_date')->nullable()->after('employee_id');
            $table->string('employment_type')->nullable()->after('join_date');
            $table->date('start_date')->nullable()->after('employment_type');
            $table->date('end_date')->nullable()->after('start_date');
            $table->string('position')->nullable()->after('end_date');
            $table->string('department')->nullable()->after('position');
            $table->string('letter')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_career', function (Blueprint $table) {
            $table->dropColumn('join_date');
            $table->dropColumn('employment_type');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('position');
            $table->dropColumn('department');
            $table->string('letter')->nullable()->change();
        });
    }
};
