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

$factory->define(App\PriceList::class, function (Faker $faker) {
    $types = ['GPS-трекеры', 'Датчики уровня топлива', 'Расходомеры топлива', 'Идентификация', 'Дополнительное оборудование', 'Услуга'];
    $type_key = array_rand($types);
    $type = $types[$type_key];
    $isService = $type === 'Услуга';
    $name = 'Model:'.$faker->randomNumber();
    $incoming_price = $faker->randomFloat(2, 10, 500);
    $installation_price = $faker->randomFloat(2, 10, 500);
    $description = $faker->text(40);
    if ($isService) {
        $name = 'Service:'.$faker->randomNumber();
        $incoming_price = null;
        $installation_price = null;
        $description = null;
    }
    return [
        'name' => $name,
        'incoming_price' => $incoming_price,
        'price' => $faker->randomFloat(2, 10, 500),
        'installation_price' => $installation_price,
        'description' => $description,
        'type' => $type
    ];
});
