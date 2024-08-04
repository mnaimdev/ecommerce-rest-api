<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\SliderSettingsInterface;
use App\Enums\SliderSettingsAnimationTypeEnum;
use App\Enums\SliderSettingsTextPositionEnum;
use App\Helpers\SendingResponse;
use App\Models\SliderSetting;
use Illuminate\Support\Facades\Auth;

class SliderSettingsRepository implements SliderSettingsInterface
{
    public function sliderSettings()
    {
        $sliderSettings = SliderSetting::all();
        return SendingResponse::response('success', 'Slider Settings Info', $sliderSettings, '', 200);
    }

    public function sliderSettingsUpdate($request)
    {

        // working with animation type
        if ($request->animation_type == SliderSettingsAnimationTypeEnum::SLIDE->value) {
            $animationType = SliderSettingsAnimationTypeEnum::SLIDE->value;
        } else if ($request->animation_type == SliderSettingsAnimationTypeEnum::FADE->value) {
            $animationType = SliderSettingsAnimationTypeEnum::FADE->value;
        } else if ($request->animation_type == SliderSettingsAnimationTypeEnum::PARALLAX->value) {
            $animationType = SliderSettingsAnimationTypeEnum::PARALLAX->value;
        } else if ($request->animation_type == SliderSettingsAnimationTypeEnum::DISTORTION->value) {
            $animationType = SliderSettingsAnimationTypeEnum::DISTORTION->value;
        }

        // text position
        if ($request->text_position == SliderSettingsTextPositionEnum::LEFT->value) {
            $textPosition = SliderSettingsTextPositionEnum::LEFT->value;
        } else if ($request->text_position == SliderSettingsTextPositionEnum::CENTER->value) {
            $textPosition = SliderSettingsTextPositionEnum::CENTER->value;
        } else if ($request->text_position == SliderSettingsTextPositionEnum::RIGHT->value) {
            $textPosition = SliderSettingsTextPositionEnum::RIGHT->value;
        }

        $sliderSettings = SliderSetting::updateOrCreate(
            [
                'id'        => 1,
            ],

            [
                'animation_type'                => $animationType,
                'enable_autoplay'               => $request->enable_autoplay,
                'autoplay_speed'                => $request->autoplay_speed,
                'height_on_tablet'              => $request->height_on_tablet,
                'text_position'                 => $textPosition,
            ]
        );

        return SendingResponse::response('success', 'Slider Settings Updated', $sliderSettings, '', 200);
    }
}
