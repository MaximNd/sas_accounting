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

$factory->define(App\CachedData::class, function (Faker $faker) {
    $column_names = ['mark', 'model', 'fuel_type', 'power', 'number'];
    $column_name_key = array_rand($column_names);
    $column_name = $column_names[$column_name_key];
    return [
        'column_name' => $column_name,
        'value' => $faker->name
    ];
});
