<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adresses', function (Blueprint $table) {
            $table->string('adress_id')->primary('adress_id');
            $table->string('postal_code', 5);
            $table->string('settlement', 70);
            $table->string('municipality', 35);
            $table->string('federal_entity_id');
            $table->foreign('federal_entity_id')->references('federal_entity_id')->on('federal_entities');
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
        Schema::drop('adresses');
    }
}
