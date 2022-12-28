<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOccasionTypeToOccasionEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('occasion_events', function (Blueprint $table) {
            //
            // $table->integer('occasion_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('occasion_events', function (Blueprint $table) {
            //
            // $table->dropColumn('occasion_type');
        });
    }
}
