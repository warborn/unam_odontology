<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_informations', function (Blueprint $table) {
            $table->string('user_id')->primary('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->string('user_name', 30);
            $table->string('last_name', 20);
            $table->string('mother_last_name', 20);
            $table->string('email', 30);
            $table->string('phone', 16);
            $table->string('gender', 1);
            $table->string('adress_id');            
            $table->foreign('adress_id')->references('adress_id')->on('adresses');
            $table->string('street', 100);            
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
        Schema::drop('personal_informations');
    }
}
