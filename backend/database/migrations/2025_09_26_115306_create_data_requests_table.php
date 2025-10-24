<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Combines all subsequent ALTER table operations into the initial CREATE table statement.
     */
    public function up(): void
    {
        // Drop the table first if it exists, to ensure a clean migration when running 'migrate:fresh'
        Schema::dropIfExists('data_requests'); 
        
        Schema::create('data_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->text('purpose');
            $table->string('requested_disease');
            $table->string('from_date')->nullable();
            $table->string('to_date')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('decline_reason')->nullable(); 
            $table->timestamp('processed_at')->nullable(); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     * Drops the table entirely.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_requests');
    }
};