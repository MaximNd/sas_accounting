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

            $table->string('name');
            $table->string('area');

            $table->integer('days');
            $table->double('price_for_days');

            $table->double('transportation_per_km');
            $table->integer('number_of_trips');
            $table->string('route');

            $table->json('users');

            $table->boolean('electronic_cards');
            $table->boolean('gps_tracking');
            $table->boolean('drones');
            $table->boolean('chemical_soil_analysis');
            $table->boolean('land_bank_registrations');
            $table->boolean('consulting');
            $table->boolean('differentiated_application');
            $table->boolean('auto_meteorolo_station');

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
