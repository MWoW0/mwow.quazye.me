<?php

namespace App\Contracts;


use App\Transaction;

interface PaymentGateway
{
    /**
     * Whether the gateway requires a token to process the payment.
     *
     * @return boolean
     */
    public function requiresToken(): bool;
    
    /**
     * Whether the gateway supports refunds.
     *
     * @return bool
     */
    public function supportRefunds(): bool;

    /**
     * Make a "one off" charge on the customer for the given amount.
     *
     * @param  int $amount
     * @param  array $options
     * @throws \Exception
     * @return Transaction
     */
    public function charge(int $amount, array $options = []): Transaction;

    /**
     * Refund a customer for a charge.
     *
     * @param  integer $amount
     * @param  Transaction $charge
     * @throws \Exception
     * @return \App\Transaction
     */
    public function refund(int $amount, Transaction $charge): Transaction;
}
