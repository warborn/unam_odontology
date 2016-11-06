<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->string('account_id', 45)->primary('account_id');
            $table->string('user_id', 20);
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->string('clinic_id', 25);
            $table->foreign('clinic_id')->references('clinic_id')->on('clinics');
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
        Schema::drop('accounts');
    }
}
