<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameDescriptionArabicInOccasionEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            //
            $table->string('price')->default(0);
            $table->string('name_arabic')->nullable();
            $table->string('description_arabic')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            //
            $table->dropColumn('price');
            $table->dropColumn('name_arabic');
            $table->dropColumn('description_arabic');
        });
    }
}
