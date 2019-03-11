<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUsersTableAddAndDeleteColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('image')->nullable();
            $table->string('content', 300)->nullable();
            $table->softDeletes();
            $table->dropColumn('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('content');
            $table->dropSoftDeletes();
            $table->string('phone_number')->nullable();
        });
    }
}
