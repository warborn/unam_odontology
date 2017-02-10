<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseTeacherPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_teacher', function(Blueprint $table){
            $table->string('course_id', 28);
            $table->foreign('course_id')->references('course_id')->on('courses')->onUpdate('cascade');
            $table->string('user_id', 20);
            $table->foreign('user_id')->references('user_id')->on('teachers');
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
        Schema::drop('course_teacher');
    }
}
