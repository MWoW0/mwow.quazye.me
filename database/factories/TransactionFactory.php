<?php

use Faker\Generator as Faker;

$factory->define(App\Transaction::class, function (Faker $faker) {
    return [
        'creator_id' => factory(\App\User::class),
        'type' => \App\Enums\TransactionType::Payment,
        'provider' => \App\Contracts\PaymentGateway::class,
        'provider_id' => null,
        'status' => \App\Enums\TransactionStatus::Open,
        'amount' => 0
    ];
});

$factory->state(App\Transaction::class, 'refund', ['type' => \App\Enums\TransactionType::Refund]);
