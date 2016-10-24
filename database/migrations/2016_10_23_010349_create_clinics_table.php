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
            $table->string('clinic_name_id')->primary('clinic_name_id');
            $table->string('adress_id');
            $table->foreign('adress_id')->references('adress_id')->on('adresses');
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
