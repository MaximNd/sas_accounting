<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\CachedData::class, 20)->create();
        factory(\App\User::class, 4)->create();
        factory(\App\Client::class, 20)->create();

//        factory(\App\PriceList::class, 50)->create()->each(function ($equipment) {
//            factory(\App\PriceListLog::class, 1)->create(['price_list_id' => $equipment->id]);
//        });

//        factory(\App\Order::class, 50)->create()->each(function ($order) {
//            factory(\App\OrderLog::class, 1)->create(['order_id' => $order->id]);
//        });
    }
}
