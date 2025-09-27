<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSexEthnicityStreetAddressToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('sex')->nullable()->after('birthdate');
            $table->string('ethnicity')->nullable()->after('sex');
            $table->string('street_address')->nullable()->after('ethnicity');
            $table->string('contact_number')->nullable()->after('street_address');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['sex', 'ethnicity', 'street_address', 'contact_number']);
        });
    }
}