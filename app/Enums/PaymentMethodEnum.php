<?php

namespace App\Enums;

enum PaymentMethodEnum: string

{
    case CASHONDELIVERY = 'cash on delivery';
    case ONLINEPAYMENT = 'online payment';
    case CASHPAYMENT = 'cash payment';
    case CARDPAYMENT = 'card payment';
    case MOBILEPAYMENT = 'mobile payment';
    case BANKTRANSFER = 'bank transfer';
}
