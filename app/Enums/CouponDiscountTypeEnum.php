<?php

namespace App\Enums;

enum CouponDiscountTypeEnum: string
{
    case PERCENTAGE = "Percentage";
    case FIXED = "Fixed Flat Amount";
    case FREESHIPPING = "Free Shipping";
}
