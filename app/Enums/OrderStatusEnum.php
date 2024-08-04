<?php

namespace App\Enums;

enum OrderStatusEnum: string

{
    case PENDING = 'Pending';
    case PROCESSING = 'Processing';
    case WAITING = 'Waiting';
    case ONTHEWAY = 'On The Way';
    case DELIVERED = 'Delivered';
    case COMPLETED = 'Completed';
    case CANCELLED = 'Cancelled';
}
