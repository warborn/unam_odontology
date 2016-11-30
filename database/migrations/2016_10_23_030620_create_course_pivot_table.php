<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function(Blueprint $table){
            $table->string('course_id', 28)->primary('course_id');
            $table->string('subject_id', 15);
            $table->foreign('subject_id')->references('subject_id')->on('subjects')->onDelete('cascade');
            $table->string('group_id', 6);
            $table->foreign('group_id')->references('group_id')->on('groups')->onDelete('cascade');
            $table->string('period_id', 7);
            $table->foreign('period_id')->references('period_id')->on('periods')->onDelete('cascade');
            $table->string('clinic_id', 25);
            $table->foreign('clinic_id')->references('clinic_id')->on('clinics')->onDelete('cascade');
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
        Schema::drop('courses');
    }
}
