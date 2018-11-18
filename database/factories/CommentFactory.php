<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'author_id' => factory(\App\User::class),
        'commentable_type' => \App\Transaction::class,
        'commentable_id' => factory(\App\Transaction::class),
        'title' => null,
        'body' => $faker->word
    ];
});
