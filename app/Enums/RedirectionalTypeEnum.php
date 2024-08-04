<?php

namespace App\Enums;

enum RedirectionalTypeEnum: string

{
    case RTL = 'rtl';
    case LTR = 'ltr';
    case UTB = 'utb';
    case BTU = 'btu';
}
