<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsSubjectsTeachersPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups_subjects_teachers', function(Blueprint $table){
            $table->string('group_period_subject_id');
            $table->foreign('group_period_subject_id')->references('group_period_subject_id')->on('groups_periods_subjects');
            $table->string('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
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
        Schema::drop('groups_subjects_teachers');
    }
}
