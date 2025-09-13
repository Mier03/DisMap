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
        Schema::table('users', function (Blueprint $table) {
                $table->string('hospital_id')->nullable()->after('name');
                $table->string('username')->unique()->after('email');
                $table->string('certification')->nullable()->after('username');
                $table->boolean('is_approved')->default(false)->after('certification');
                });
            }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
              $table->dropColumn(['hospital_id', 'username', 'certification', 'is_approved']);
        });
    }
};
