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
        Schema::table('employee', function (Blueprint $table) {
            $table->dropForeign('employee_ptkp_id_foreign');
            $table->dropColumn([
                'tax_number',
                'ptkp_id', 
                'bpjs_ketenagakerjaan',
                'bpjs_kesehatan',
                'medical_insurance',
                'division',
                'position',
                'agreement_type',
                'join_date',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee', function (Blueprint $table) {
            //
        });
    }
};
