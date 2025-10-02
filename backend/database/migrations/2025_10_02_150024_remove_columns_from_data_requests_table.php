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
            //
            $table->dropForeign(['handled_by_admin_id']);
            $table->dropColumn('handled_by_admin_id');
            $table->dropColumn('requested_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_requests', function (Blueprint $table) {
            //
            $table->string('requested_type')->default('statistics');
            $table->foreignId('handled_by_admin_id')->nullable()->constrained('users');
        });
    }
};
