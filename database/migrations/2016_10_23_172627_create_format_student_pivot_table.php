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
            $table->string('user_id', 20);
            $table->foreign('user_id')->references('user_id')->on('students')->onDelete('cascade');
            $table->string('format_id', 10);
            $table->foreign('format_id')->references('format_id')->on('formats')->onDelete('cascade');
            $table->string('course_id', 28);
            $table->foreign('course_id')->references('course_id')->on('courses')->onDelete('cascade')->onUpdate('cascade');
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
