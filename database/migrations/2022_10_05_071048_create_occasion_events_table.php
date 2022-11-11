<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOccasionEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('occasion_events', function (Blueprint $table) {
            $table->id();
            $table->integer('occasion_event_id')->unsigned();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('address_1')->nullable();
            $table->string('image')->nullable();
            $table->string('address_2')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('max_capacity')->nullable();
            $table->string('min_capacity')->nullable();
            $table->string('availability_start_date')->nullable();
            $table->string('availability_end_date')->nullable();
            $table->string('availability_time_in')->nullable();
            $table->string('availability_time_out')->nullable();
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
        Schema::dropIfExists('occasion_events');
    }
}
