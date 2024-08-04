<?php

namespace App\Enums;

enum ProductReviewStatusEnum: string
{
    case PUBLISHED = 'Published';
    case UNPUBLISHED = 'Unpublished';
}
