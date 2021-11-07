<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParameterValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameter_value', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parameter_id')->unsigned();
            $table->foreign('parameter_id')->references('id')->on('parameter')->cascadeOnDelete();
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parameter_value');
    }
}
