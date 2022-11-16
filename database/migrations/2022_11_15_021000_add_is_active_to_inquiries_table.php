<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveToInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->string('type');
            $table->tinyInteger('is_active')->default(0)->unsigned();
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->string('type');
            $table->tinyInteger('is_active')->unsigned();
        });
    }
}
