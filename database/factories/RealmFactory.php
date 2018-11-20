<?php

use Faker\Generator as Faker;

$factory->define(App\Realm::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'address' => '127.0.0.1',
        'localAddress' => '127.0.0.1',
        'localSubnetMask' => '255.255.255.0'
    ];
});
