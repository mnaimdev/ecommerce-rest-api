<?php

namespace App\Enums;

enum CustomerTypeEnum: string

{
    case SOCIAL = 'social';
    case WALKING = 'walking';
    case ECOMMERCE = 'ecommerce';
}
