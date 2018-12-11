<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGameAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('emulator')->index();
            $table->string('expansion')->index()->nullable();
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('realm_id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('game_accounts');
    }
}
