<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableClinicsRolesUsersPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinics_roles_users', function(Blueprint $table){
            $table->string('clinic_role_user_id')->primary('clinic_role_user_id');
            $table->string('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->string('clinic_name_id');
            $table->foreign('clinic_name_id')->references('clinic_name_id')->on('clinics');
            $table->string('role_id');
            $table->foreign('role_id')->references('role_id')->on('roles');
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
        Schema::drop('clinics_roles_users');
    }
}
