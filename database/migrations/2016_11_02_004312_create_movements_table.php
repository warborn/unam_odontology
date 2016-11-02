<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->datetime('timestamp')->primary('timestamp');
            $table->string('receiver_account_id');
            $table->foreign('receiver_account_id')->references('account_id')->on('accounts');
            $table->string('maker_account_id');
            $table->foreign('maker_account_id')->references('account_id')->on('accounts');
            $table->string('ip', 16);
            $table->string('privilege_id');
            $table->foreign('privilege_id')->references('privilege_id')->on('privileges');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('movements');
    }
}
