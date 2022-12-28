<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOccasionIdToOccasionTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('occasion_types', function (Blueprint $table) {
            //
            // $table->integer('occasion_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('occasion_types', function (Blueprint $table) {
            //
            // $table->dropColumn('occasion_id');
        });
    }
}
