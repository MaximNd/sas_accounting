<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_lists', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->double('incoming_price')->nullable();
            $table->double('price');
            $table->double('installation_price_for_one')->nullable();
            $table->double('installation_price_for_two')->nullable();
            $table->double('installation_price_for_three')->nullable();
            $table->string('type');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('price_lists');
    }
}
