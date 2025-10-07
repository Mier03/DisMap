<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('data_requests', function (Blueprint $table) {
            $table->text('decline_reason')->nullable()->after('status');
            $table->timestamp('processed_at')->nullable()->after('decline_reason');
        });
    }

    public function down()
    {
        Schema::table('data_requests', function (Blueprint $table) {
            $table->dropColumn(['decline_reason', 'processed_at']);
        });
    }
};