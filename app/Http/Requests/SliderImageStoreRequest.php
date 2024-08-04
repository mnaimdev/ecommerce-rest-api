<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderImageStoreRequest extends FormRequest
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
            'name'                      => 'required|unique:slider_images,name',
            'status'                    => 'nullable',
            'redirectional_type'        => 'nullable',
            'title'                     => 'nullable',
            'title_color'               => 'nullable',
            'title_font_size'           => 'nullable',
            'sub_title'                 => 'nullable',
            'sub_title_color'           => 'nullable',
            'sub_title_font_size'       => 'nullable',
            'button_text'               => 'nullable',
            'button_link'               => 'nullable|url',
            'button_color'              => 'nullable',
            'button_hover_color'        => 'nullable',
            'text_color'                => 'nullable',
            'text_hover_color'          => 'nullable',
            'image'                     => 'nullable',
        ];
    }
}
