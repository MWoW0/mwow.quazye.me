<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TransactionStatus extends Enum
{
    const Open = 'Open';
    const Closed = 'Closed';
}
