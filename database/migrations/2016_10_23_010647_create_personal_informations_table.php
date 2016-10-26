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
            $table->string('phone', 16)->nullable();
            $table->string('gender', 1)->nullable();
            $table->string('address_id')->nullable();
            $table->foreign('address_id')->references('address_id')->on('addresses');
            $table->string('street', 100)->nullable();
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
