<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInactiveAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inactive_accounts', function (Blueprint $table) {
            $table->string('account_id')->primary('account_id');
            $table->foreign('account_id')->references('account_id')->on('accounts');
            $table->string('status')->default('disabled');
            $table->string('reason', 150)->nullable();
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
        Schema::drop('inactive_accounts');
    }
}
