<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function(Blueprint $table){
            $table->string('user_id', 20)->primary('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->string('age', 2);
            $table->string('federal_entity_id', 35);
            $table->foreign('federal_entity_id')->references('federal_entity_id')->on('federal_entities');
            $table->string('ocupation', 25);
            $table->string('school_grade', 20);
            $table->string('civil_status', 25);
            $table->string('phone', 16);
            $table->boolean('has_medical_service')->default(false);
            $table->string('service_name', 25)->nullable();
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
        Schema::drop('patients');
    }
}
