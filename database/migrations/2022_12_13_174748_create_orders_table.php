<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('cart_id')->unsigned();
            $table->string('payment_method');
            $table->string('contact_details');
            $table->string('location');
            $table->string('agent');
            $table->string('notes');
            $table->enum('status', ['pending', 'ongoing', 'fulfilled']);
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
        Schema::dropIfExists('orders');
    }
}
