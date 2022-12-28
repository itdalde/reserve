<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            //
            $table->text('tags')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('location')->nullable();
            $table->integer('is_custom')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            //
            $table->dropColumn('tags');
            $table->dropColumn('phone_number');
            $table->dropColumn('location');
            $table->dropColumn('is_custom');
        });
    }
}
