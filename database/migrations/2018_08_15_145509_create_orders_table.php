<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');

            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients');

            $table->boolean('is_sent');
            $table->boolean('is_agreed');
            $table->boolean('is_paid');
            $table->boolean('is_installation_finished');

            $table->double('dollar_rate');
            $table->date('dollar_date');

            $table->string('name');
            $table->double('area');

            $table->integer('days')->nullable();
            $table->double('price_for_day')->nullable();

            $table->double('installation_discount')->nullable();
            $table->double('equipment_discount')->nullable();

            $table->double('price_for_transportation_per_km')->nullable();
            $table->integer('number_of_trips')->nullable();
            $table->double('transportation_kms')->nullable();
            $table->string('route')->nullable();

            $table->json('services');


            $table->softDeletes();
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
