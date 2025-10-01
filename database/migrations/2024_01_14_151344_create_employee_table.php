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
        Schema::create('employee', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->unique()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('employee_no');
            $table->string('access_card_id')->nullable();
            $table->string('firstname');
            $table->string('lastname')->nullable();
            $table->string('nickname')->nullable();
            $table->string('id_card', 20)->unique();
            $table->string('birth_place');
            $table->date('birth_date');
            $table->enum('gender', ['Male', 'Female'])->default('Male');
            $table->enum('marital_status', ['Single', 'Married', 'Divorced', 'Widowed'])->default('Single');
            $table->string('religion')->nullable();
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('id_card_address', 255);
            $table->string('address', 500)->nullable();
            $table->string('tax_number', 20)->nullable();
            $table->unsignedBigInteger('ptkp_id')->unique()->nullable();
            $table->foreign('ptkp_id')->references('id')->on('ptkp')->onDelete('cascade');
            $table->string('bpjs_ketenagakerjaan')->nullable();
            $table->string('bpjs_kesehatan')->nullable();
            $table->string('medical_insurance')->nullable();
            $table->string('kta')->nullable();
            $table->string('phone_number');
            $table->string('email');
            $table->string('social_media')->nullable();
            $table->string('clothes_size', 50)->nullable();
            $table->string('trouser_size', 50)->nullable();
            $table->string('shoes_size', 50)->nullable();
            $table->string('language')->nullable();
            $table->string('educational_level')->nullable();
            $table->string('major')->nullable();
            $table->string('skill')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_number')->nullable();
            $table->string('division')->nullable();
            $table->string('position')->nullable();
            $table->enum('agreement_type', ['Contract', 'Permanent'])->default('Contract');
            $table->date('join_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee');
    }
};
