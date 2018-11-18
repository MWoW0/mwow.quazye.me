<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserType extends Enum
{
    const Player = 'Player';
    const Admin = 'Administrator';
    const Moderator = 'Moderator';
}
