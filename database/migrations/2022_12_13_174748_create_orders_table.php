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
            $table->string('reference_no');
            $table->string('payment_method');
            $table->string('contact_details');
            $table->string('location');
            $table->string('promo_code')->nullable();
            $table->string('agent');
            $table->string('notes');
            $table->enum('timeline', ['order-placed', 'connected-to-agent', 'connected-to-provider', 'order-completed'])->default('order-placed');
            $table->enum('status', ['pending', 'accepted', 'declined', 'completed', 'cancelled'])->default('pending');
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
