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
        Schema::create('patient_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('disease_id')->constrained('diseases')->onDelete('cascade');
            $table->foreignId('reported_dh_id')->constrained('doctor_hospitals')->onDelete('cascade');
            $table->text(column: 'reported_remarks')->nullable();
            $table->foreignId('recovered_dh_id')->nullable()->constrained('doctor_hospitals')->onDelete('cascade');
            $table->text(column: 'recovered_remarks')->nullable();
            $table->text('status');
            $table->timestamp('date_reported'); 
            $table->timestamp('date_recovered')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_records');
    }
};