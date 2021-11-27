<?php

use App\ParameterValue;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStateToTutorshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tutorship', function (Blueprint $table) {
            $table->integer('state')->after('observation')->default(13);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tutorship', function (Blueprint $table) {
            $table->dropColumn('state');
        });
    }
}
