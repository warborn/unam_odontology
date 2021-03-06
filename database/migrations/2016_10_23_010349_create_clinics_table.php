<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->string('clinic_id', 25)->primary('clinic_id');
            $table->string('address_id', 200);
            $table->foreign('address_id')->references('address_id')->on('addresses')->onUpdate('cascade');
            $table->string('clinic_email', 25);
            $table->string('clinic_phone', 16);
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
        Schema::drop('clinics');
    }
}
