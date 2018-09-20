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

            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');

            $table->integer('order');

            $table->string('image')->nullable();
            $table->string('mark')->nullable();
            $table->string('model')->nullable();
            $table->string('year_of_issue')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('power')->nullable();
            $table->string('number')->nullable();

            $table->integer('gps_tracker')->nullable();
            $table->json('fuel_gauge')->nullable();
            $table->integer('counter')->nullable();
            $table->integer('rf_id')->nullable();
            $table->integer('reader_of_trailed_equipment')->nullable();
            $table->integer('can_reader')->nullable();
            $table->integer('deaerator')->nullable();
            $table->json('additional_equipment')->nullable();
            $table->json('cn03')->nullable();
            $table->json('rs01')->nullable();

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
