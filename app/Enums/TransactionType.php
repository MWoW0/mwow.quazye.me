<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TransactionType extends Enum
{
    const Payment = 'Payment';
    const Refund = 'Refund';
}
