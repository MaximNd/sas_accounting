<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceListLogChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_list_log_changes', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('price_list_log_id')->unsigned();
            $table->foreign('price_list_log_id')->references('id')->on('price_list_logs');

            $table->json('before');
            $table->json('after');

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
        Schema::dropIfExists('price_list_log_changes');
    }
}
