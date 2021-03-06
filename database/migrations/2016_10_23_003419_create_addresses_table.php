<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->string('address_id', 200)->primary('address_id');
            $table->string('postal_code', 6);
            $table->string('settlement', 70);
            $table->string('municipality', 70);
            $table->string('federal_entity_id', 35);
            $table->foreign('federal_entity_id')->references('federal_entity_id')->on('federal_entities')->onUpdate('cascade');
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
        Schema::drop('addresses');
    }
}
