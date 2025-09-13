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
        Schema::create('doctor_hospital_table', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');       // link to users table
            $table->unsignedBigInteger('hospital_id');   // link to hospitals table
            $table->string('status')->default('active'); // default status
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('hospital_id')->references('id')->on('hospitals_table')->onDelete('cascade');
            
            // Optional: prevent duplicate assignment of the same doctor to the same hospital
            $table->unique(['user_id', 'hospital_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_hospital_table');
    }
};
