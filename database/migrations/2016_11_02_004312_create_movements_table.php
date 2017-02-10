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
            $table->datetime('timestamp')->index();
            $table->string('receiver_account_id', 45)->nullable()->index();
            $table->foreign('receiver_account_id')->references('account_id')->on('accounts');
            $table->string('maker_account_id', 45)->index();
            $table->foreign('maker_account_id')->references('account_id')->on('accounts');
            $table->string('ip', 16)->index();
            $table->string('privilege_id', 10)->index();
            $table->foreign('privilege_id')->references('privilege_id')->on('privileges')->onUpdate('cascade');
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
