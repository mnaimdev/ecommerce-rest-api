<?php

namespace App\Enums;

enum DeliveryTypeEnum: string
{
    case OWNDELIVERY = 'own delivery';
    case COURIERSERVICE = 'courier service';
    case SELFRECEIVE = 'self receive';
}
