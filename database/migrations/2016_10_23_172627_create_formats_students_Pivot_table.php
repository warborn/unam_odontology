<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormatsStudentsPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formats_students', function(Blueprint $table){
            $table->string('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->integer('format_id');
            $table->foreign('format_id')->references('format_id')->on('formats');
            $table->string('group_period_subject_id');
            $table->foreign('group_period_subject_id')->references('group_period_subject_id')->on('groups_periods_subjects');
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
        Schema::drop('formats_students');
    }
}
