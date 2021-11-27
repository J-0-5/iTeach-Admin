<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutorship', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('teacher_id')->unsigned();
            $table->foreign('teacher_id')->references('id')->on('users')->cascadeOnDelete();
            $table->bigInteger('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('users')->cascadeOnDelete();
            $table->bigInteger('subjects_id')->unsigned();
            $table->foreign('subjects_id')->references('id')->on('subjects')->cascadeOnDelete();
            $table->bigInteger('schedule_id')->unsigned();
            $table->foreign('schedule_id')->references('id')->on('schedule')->cascadeOnDelete();
            $table->date('date');
            $table->text('observation')->nullable();
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
        Schema::dropIfExists('tutorship');
    }
}
