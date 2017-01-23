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
            $table->string('user_id', 20)->primary('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->string('name', 30);
            $table->string('last_name', 20);
            $table->string('mother_last_name', 20);
            $table->string('email', 80)->unique()->nullable();
            $table->string('phone', 16)->nullable();
            $table->string('gender', 1)->nullable();
            $table->string('address_id', 200)->nullable();
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
