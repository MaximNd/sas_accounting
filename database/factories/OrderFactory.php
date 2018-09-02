<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'client_id' => random_int(1, 20),
        'is_sent' => $faker->boolean,
        'is_agreed' => $faker->boolean,
        'is_paid' => $faker->boolean,
        'dollar_rate' => 28.246117,
        'name' => $faker->name,
        'area' => $faker->randomFloat(2, 50, 500),
        'days' => $faker->randomNumber(1),
        'price_for_day' => 720,
        'price_for_transportation_per_km' => 4.5,
        'number_of_trips' => 2,
        'transportation_kms' => $faker->randomFloat(2, 100, 500),
        'route' => $faker->word.'-'.$faker->word,
        'services' => []
    ];
});
