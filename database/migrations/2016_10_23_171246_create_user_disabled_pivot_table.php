<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDisabledPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_disabled', function(Blueprint $table){
            $table->string('clinic_role_user_id');
            $table->foreign('clinic_role_user_id')->references('clinic_role_user_id')->on('clinic_role_user');
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
        Schema::drop('user_disabled');
    }
}
