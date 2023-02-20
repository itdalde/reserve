<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('order_id')->unsigned();
            $table->tinyInteger('service_id')->unsigned();

            $table->dateTime('schedule_start_datetime');
            $table->dateTime('schedule_end_datetime');
            $table->integer('guests')->unsigned();
            $table->enum('timeline', ['order-placed', 'order-accepted', 'order-declined', 'processing', 'order-completed'])->default('order-placed');
            $table->enum('status', ['placed', 'accepted', 'declined', 'pending', 'processing', 'cancelled', 'completed'])->default('accepted');
            $table->tinyInteger('is_custom')->default(0);
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
        Schema::dropIfExists('order_items');
    }
}
