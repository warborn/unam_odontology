<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupPeriodSubjectPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_period_subject', function(Blueprint $table){
            $table->string('group_period_subject_id')->primary('group_period_subject_id');
            $table->string('subject_id');
            $table->foreign('subject_id')->references('subject_id')->on('subjects')->onDelete('cascade');
            $table->string('group_id');
            $table->foreign('group_id')->references('group_id')->on('groups')->onDelete('cascade');
            $table->string('period_id');
            $table->foreign('period_id')->references('period_id')->on('periods')->onDelete('cascade');
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
        Schema::drop('group_period_subject');
    }
}
