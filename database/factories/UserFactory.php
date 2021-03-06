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

$factory->define(App\User::class, function (Faker $faker) {
    $roles = ['admin', 'user'];
    $role = $roles[array_rand($roles)];
    return [
        'role' => $role,
        'position' => 'director',
        'last_name' => $faker->lastName,
        'first_name' => $faker->firstName,
        'mid_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'telephone' => '066 818 36 79',
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});
