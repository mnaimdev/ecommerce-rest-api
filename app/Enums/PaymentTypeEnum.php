<?php

namespace App\Enums;

enum PaymentTypeEnum: string
{
    case FULL = 'full';
    case PARTIAL = 'partial';
}
