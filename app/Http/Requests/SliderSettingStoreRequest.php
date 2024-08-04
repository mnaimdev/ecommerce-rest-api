<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderSettingStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'animation_type'        => 'required',
            'height_on_tablet'      => 'nullable',
            'enable_autoplay'       => 'nullable',
            'autoplay_speed'        => 'nullable',
            'text_position'         => 'required',
        ];
    }
}
