<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
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
            'name'              => 'required',
            'slug'              => 'required',
            'serial_no'         => 'nullable',
            'description'       => 'nullable',
            'meta_tag'          => 'nullable',
            'meta_title'        => 'nullable',
            'meta_description'  => 'nullable',
            'is_featured'       => 'nullable',
            'status'            => 'required',
            'image'             => 'nullable',
            'banner_image'      => 'nullable',
            'parent_id'         => 'nullable',
        ];
    }
}
