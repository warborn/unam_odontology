<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersDisabledPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_disabled', function(Blueprint $table){
            $table->string('clinic_role_user_id');
            $table->foreign('clinic_role_user_id')->references('clinic_role_user_id')->on('clinics_roles_users');
            $table->datetime('date_hour_movement');
            $table->foreign('date_hour_movement')->references('date_hour_movement')->on('movements');
            $table->string('reason', 150);
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
        Schema::drop('users_disabled');
    }
}
