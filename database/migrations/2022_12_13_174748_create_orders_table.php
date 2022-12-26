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
            $table->tinyInteger('payment_method');
            $table->string('contact_details')->nullable();;
            $table->string('location')->nullable();;
            $table->string('promo_code')->nullable();
            $table->string('agent')->nullable();;
            $table->string('notes')->nullable();;
            $table->enum('timeline', ['order-placed', 'processing', 'order-completed'])->default('order-placed');
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
