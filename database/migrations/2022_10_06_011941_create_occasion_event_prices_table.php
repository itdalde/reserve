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
        Schema::create('services_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('occasion_event_id')->unsigned();
            $table->integer('plan_id')->unsigned();
            $table->enum('service_unit', ['per_person', 'per_pax'])->default('per_person');
            $table->float('service_price')->default(0);
            $table->string('package')->nullable();
            $table->integer('min_capacity')->nullable()->default(0);
            $table->integer('max_capacity')->nullable()->default(0);
            $table->string('package_details')->nullable();
            $table->float('package_price')->default(0);
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
        Schema::dropIfExists('services_prices');
    }
}
