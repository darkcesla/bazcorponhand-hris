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
            $table->dropColumn('one_point_five');
            $table->dropColumn('two');
            $table->dropColumn('three');
            $table->dropColumn('four');
            $table->double('total_hour')->nullable()->after('end_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('overtime', function (Blueprint $table) {
            $table->double('one_point_five')->nullable()->after('end_time');
            $table->double('two')->nullable()->after('end_time');
            $table->double('three')->nullable()->after('end_time');
            $table->double('four')->nullable()->after('end_time');
            $table->dropColumn('total_hour');
        });
    }
};
