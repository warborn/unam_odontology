<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountRolePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_role', function (Blueprint $table) {
            $table->string('account_id');
            $table->foreign('account_id')->references('account_id')->on('accounts');
            $table->string('role_id');
            $table->foreign('role_id')->references('role_id')->on('roles');
            $table->primary(['account_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('account_role');
    }
}
