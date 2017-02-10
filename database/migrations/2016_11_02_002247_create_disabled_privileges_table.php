<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisabledPrivilegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disabled_privileges', function (Blueprint $table) {
            $table->string('account_id', 45)->index();
            $table->foreign('account_id')->references('account_id')->on('accounts');
            $table->string('privilege_id', 10);
            $table->foreign('privilege_id')->references('privilege_id')->on('privileges')->onUpdate('cascade');
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
        Schema::drop('disabled_privileges');
    }
}
