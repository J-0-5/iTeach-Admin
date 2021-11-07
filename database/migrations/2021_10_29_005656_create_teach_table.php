<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teach', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('teacher_id')->unsigned();
            $table->foreign('teacher_id')->references('id')->on('users')->cascadeOnDelete();
            $table->bigInteger('subjects_id')->unsigned();
            $table->foreign('subjects_id')->references('id')->on('subjects')->cascadeOnDelete();
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
        Schema::dropIfExists('teach');
    }
}
