<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrivilegesDisabledPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('privileges_disabled', function(Blueprint $table){
            $table->string('privilege_id');
            $table->foreign('privilege_id')->references('privilege_id')->on('privileges');
            $table->datetime('date_hour_movement');
            $table->foreign('date_hour_movement')->references('date_hour_movement')->on('movements');
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
        Schema::drop('privileges_disabled');
    }
}
