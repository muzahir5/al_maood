<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->integer('status')->default(0);
            $table->string('mob_verified')->after('mobile_number')->nullable();
            $table->integer('is_loged_in')->nullable();
            $table->integer('count_login')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('village')->nullable();
            $table->string('mobile_network')->nullable();
            $table->string('logged_token')->nullable();
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
            $table->dropColumn('status');
            $table->dropColumn('mob_verified');
            $table->dropColumn('is_loged_in');
            $table->dropColumn('count_login');
            $table->dropColumn('country');
            $table->dropColumn('city');
            $table->dropColumn('village');
            $table->dropColumn('mobile_network');
            $table->dropColumn('logged_token');
        });
    }
}
