<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyLinkedSocialAccountsTableAddTokenAndTokenSecret extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('linked_social_accounts', function (Blueprint $table) {
            $table->string('token', 500)->nullable();
            $table->string('token_secret', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('linked_social_accounts', function (Blueprint $table) {
            $table->dropColumn('token');
            $table->dropColumn('token_secret');
        });
    }
}
