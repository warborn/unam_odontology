<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interns', function (Blueprint $table) {
            $table->string('user_id')->primary('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->date('service_start_date');
            $table->date('service_end_date');
            $table->string('account_number', 10);
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
        Schema::drop('interns');
    }
}
