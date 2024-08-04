<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialShopStoreRequest extends FormRequest
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
            'page_name'             => 'required|unique:social_shops,page_name',
            'page_url'              => 'required|url',
            'status'                => 'nullable',
            'page_logo'             => 'nullable'
        ];
    }
}
