<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ? : $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'confirmed'      => true,
    ];
});


$factory->state(App\User::class, 'unconfirmed', function () {
    return [
        'confirmed' => false,
    ];
});
