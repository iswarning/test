<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserRole extends Enum
{
    const admin =   0;
    const agent =   1;
    const legalAgent = 2;
}
