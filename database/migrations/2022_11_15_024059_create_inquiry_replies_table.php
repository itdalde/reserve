<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInquiryRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiry_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inquiries_id');
            $table->unsignedBigInteger('user_id');
            $table->text('description')->nullable();
            $table->tinyInteger('active')->default(1)->unsigned();
            $table->tinyInteger('is_owner')->default(0)->unsigned();
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
        Schema::dropIfExists('inquiry_replies');
    }
}
