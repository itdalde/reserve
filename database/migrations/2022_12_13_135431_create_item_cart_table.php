<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('cart_id')->unsigned();
            $table->tinyInteger('service_id')->unsigned();
            $table->dateTime('schedule_start_datetime');
            $table->dateTime('schedule_end_datetime');
            $table->integer('guests')->unsigned();
            $table->enum('status', ['active', 'ordered'])->default('active');
            $table->tinyInteger('is_custom')->default(0);
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
        Schema::dropIfExists('cart_items');
    }
}
