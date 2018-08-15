<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGPSDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('g_p_s_datas', function (Blueprint $table) {
            $table->increments('id');

            $table->string('image');
            $table->string('mark');
            $table->string('model');
            $table->string('year_of_issue');
            $table->string('fuel_type');
            $table->string('power');
            $table->string('number');

            $table->integer('gps_tracker');
            $table->json('fuel_gauge');
            $table->integer('counter');
            $table->integer('rf_id');
            $table->integer('reader_of_trailed_equipment');
            $table->integer('connect_module');
            $table->integer('can_reader');
            $table->integer('deaerator');
            $table->json('additional_equipment');

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
        Schema::dropIfExists('g_p_s_datas');
    }
}
