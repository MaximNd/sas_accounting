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

            $table->integer('days');
            $table->double('price_for_day');

            $table->double('price_for_transportation_per_km');
            $table->integer('number_of_trips');
            $table->double('transportation_kms');
            $table->string('route');

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
