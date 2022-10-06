<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOccasionEventReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('occasion_event_reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('occasion_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('rate')->default(0);
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
        Schema::dropIfExists('occasion_event_reviews');
    }
}
