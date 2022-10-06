<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOccasionEventPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('occasion_event_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('occasion_id')->unsigned();
            $table->integer('plan_id')->unsigned();
            $table->float('price')->default(0);
            $table->tinyInteger('active')->default(0)->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('occasion_event_prices');
    }
}
