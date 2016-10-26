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
            $table->datetime('date_hour_movement')->primary('date_hour_movement');
            $table->string('clinic_role_user_id');
            $table->foreign('clinic_role_user_id')->references('clinic_role_user_id')->on('clinic_role_user');
            $table->string('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->string('ip', 16);
            $table->string('movement_type_id');
            $table->foreign('movement_type_id')->references('movement_type_id')->on('movement_types');
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
        Schema::drop('movements');
    }
}
