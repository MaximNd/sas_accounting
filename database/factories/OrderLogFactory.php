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
$factory->define(App\OrderLog::class, function (Faker $faker){
    $user_ids = [1,2,3,4];
    $user_id = $user_ids[array_rand($user_ids)];
    return [
        'order_id' => function() {
            return factory(App\Order::class)->create()->id;
        },
        'user_id' => $user_id,
        'before' => '{}',
        'after' => '{}',
        'type' => 'Создание'
    ];
});
