<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupStudentPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_student', function(Blueprint $table){
            $table->string('user_id');
            $table->foreign('user_id')->references('user_id')->on('students');
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
        Schema::drop('group_student');
    }
}
