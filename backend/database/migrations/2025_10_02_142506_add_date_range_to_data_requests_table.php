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
        Schema::table('data_requests', function (Blueprint $table) {
            $table->string('from_date')->nullable()->after('requested_disease');
            $table->string('to_date')->nullable()->after('from_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_requests', function (Blueprint $table) {
            $table->dropColumn(['from_date', 'to_date']);
        });
    }
};
