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
            $table->string('format_id', 10)->primary('format_id');
            $table->string('user_intern_id', 20);
            $table->foreign('user_intern_id')->references('user_id')->on('interns');
            $table->string('clinic_id', 25);
            $table->foreign('clinic_id')->references('clinic_id')->on('clinics');
            $table->string('user_patient_id', 20);
            $table->foreign('user_patient_id')->references('user_id')->on('patients');
            $table->string('medical_history_number', 8);
            $table->datetime('hour_date_fill');
            $table->string('consultation_reason', 70);
            $table->boolean('has_disease')->default(false);
            $table->string('general_disease', 20);
            $table->foreign('general_disease')->references('disease_id')->on('diseases')->nullable();
            $table->string('other_disease', 30)->nullable();
            $table->boolean('medical_treatment')->default(false);
            $table->string('therapeutic_used', 30)->nullable();
            $table->string('observations', 250)->nullable();
            $table->string('referred_by', 50)->nullable();
            $table->string('dental_disease', 20);
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
