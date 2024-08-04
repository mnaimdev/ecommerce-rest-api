<?php

namespace App\Enums;

enum SliderSettingsAnimationTypeEnum: string

{
    case SLIDE = 'slide';
    case FADE = 'fade';
    case PARALLAX = 'parallax';
    case DISTORTION = 'distortion';
}
