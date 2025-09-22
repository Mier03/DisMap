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
        Schema::table('doctor_hospitals', function (Blueprint $table) {
            //
            $table->enum('status', ['pending', 'approved', 'rejected','removed'])->default('pending');
            $table->string('certification')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctor_hospitals', function (Blueprint $table) {
            //
             $table->dropColumn(['status', 'certification']);
        });
    }
};
