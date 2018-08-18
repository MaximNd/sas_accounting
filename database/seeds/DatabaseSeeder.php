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
        factory(\App\User::class, 4)->create();
        factory(\App\Client::class, 20)->create();

        factory(\App\PriceList::class, 20)->create()->each(function ($equipment) {
            factory(\App\PriceListLog::class, 5)->create(['price_list_id' => $equipment->id]);
        });
    }
}
