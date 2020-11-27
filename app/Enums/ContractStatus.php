<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ContractStatus extends Enum
{
    const statusName = [
        'Bỏ giữ chỗ',
        "Trả giữ chỗ",
        'Đang giữ chỗ'
    ];
}
