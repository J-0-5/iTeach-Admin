<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('teacher_id')->unsigned();
            $table->foreign('teacher_id')->references('id')->on('users')->cascadeOnDelete();
            $table->bigInteger('day')->unsigned();
            $table->foreign('day')->references('id')->on('parameter_value')->cascadeOnDelete();
            $table->time('start_hour');
            $table->time('final_hour');
            $table->bigInteger('campus')->unsigned();
            $table->foreign('campus')->references('id')->on('parameter_value')->cascadeOnDelete();
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
        Schema::dropIfExists('schedule');
    }
}
