<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePrivilegesRolesPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('privileges_roles', function(Blueprint $table){
            $table->string('role_id');
            $table->foreign('role_id')->references('role_id')->on('roles');
            $table->string('privilege_id');
            $table->foreign('privilege_id')->references('privilege_id')->on('privileges');
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
        Schema::drop('privileges_roles');
    }
}
