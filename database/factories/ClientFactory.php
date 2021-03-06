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

$factory->define(App\Client::class, function (Faker $faker) {
    return [
        'person_full_name' => $faker->lastName.' '.$faker->firstName.' '.$faker->lastName,
        'company_name' => 'company:'.$faker->company,
        'email' => $faker->safeEmail,
        'area' => $faker->numberBetween(50, 500),
        'telephone' => $faker->phoneNumber,
        'address' => $faker->address,
        'comment' => $faker->text(50)
    ];
});
