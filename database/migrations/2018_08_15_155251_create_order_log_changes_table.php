<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderLogChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_log_changes', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('order_log_id')->unsigned();
            $table->foreign('order_log_id')->references('id')->on('order_logs');

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
        Schema::dropIfExists('order_log_changes');
    }
}
