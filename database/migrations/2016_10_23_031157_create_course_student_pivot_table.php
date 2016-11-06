<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseStudentPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_student', function(Blueprint $table){
            $table->string('user_id', 20);
            $table->foreign('user_id')->references('user_id')->on('students');
            $table->string('course_id', 28);
            $table->foreign('course_id')->references('course_id')->on('courses');
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
        Schema::drop('course_student');
    }
}
