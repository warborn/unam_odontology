<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formats', function (Blueprint $table) {
            $table->string('format_id')->primary('format_id');
            $table->string('user_intern_id');
            $table->foreign('user_intern_id')->references('user_id')->on('interns');
            $table->string('clinic_id');
            $table->foreign('clinic_id')->references('clinic_id')->on('clinics');
            $table->string('user_patient_id');
            $table->foreign('user_patient_id')->references('user_id')->on('patients');
            $table->string('medical_history_number', 8);
            $table->datetime('hour_date_fill');
            $table->string('reason_consultation', 70);
            $table->string('disease');
            $table->string('general_disease');
            $table->foreign('general_disease')->references('disease_id')->on('diseases');
            $table->string('other_disease', 30);
            $table->mediumtext('medical_treatment');
            $table->string('therapeutic_used', 30);
            $table->string('observations', 250);
            $table->string('referred_by', 50);
            $table->string('dental_disease');
            $table->foreign('dental_disease')->references('disease_id')->on('diseases');
            $table->mediumtext('format_status');
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
        Schema::drop('formats');
    }
}
