<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOccasionEventAddonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services_addons', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->string('price');
            $table->string('description');
            $table->unsignedBigInteger('occasion_event_id');
            $table->tinyInteger('active')->default(1)->unsigned();
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
        Schema::dropIfExists('services_addons');
    }
}
