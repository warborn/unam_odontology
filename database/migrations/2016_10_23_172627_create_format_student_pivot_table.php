<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormatStudentPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('format_student', function(Blueprint $table){
            $table->string('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->string('format_id');
            $table->foreign('format_id')->references('format_id')->on('formats');
            $table->string('group_period_subject_id');
            $table->foreign('group_period_subject_id')->references('group_period_subject_id')->on('group_period_subject');
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
        Schema::drop('format_student');
    }
}
