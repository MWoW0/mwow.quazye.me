<?php

use App\Jobs\CreateGameAccountJob;
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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->state(\App\User::class, 'player', function (Faker $faker) {
    return [
        'type' => \App\Enums\UserType::Player,
        'account_name' => $faker->firstName
    ];
});
$factory->state(\App\User::class, 'admin', ['type' => \App\Enums\UserType::Admin]);
$factory->state(\App\User::class, 'moderator', ['type' => \App\Enums\UserType::Moderator]);

$factory->state(\App\User::class, 'with game account', []);
$factory->afterCreatingState(\App\User::class, 'with game account', function ($user) {
	(new CreateGameAccountJob($user, 'secret'))->handle();
});
