<?php

namespace App\Enums;

enum ProductStatusEnum: string
{
    case PUBLISHED = 'Published';
    case DRAFT = 'Draft';
    case UNPUBLISHED = 'Unpublished';
}
