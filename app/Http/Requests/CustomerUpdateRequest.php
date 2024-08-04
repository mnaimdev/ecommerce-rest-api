<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
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
            'pos_branch_id'             => 'nullable',
            'name'                      => 'required',
            'email'                     => 'required',
            'phone'                     => 'required',
            'gender'                    => 'nullable',
            'profile_picture'           => 'nullable',
            'social_shop_id'            => 'nullable',
            'registration_source'       => 'nullable',
            'customer_type'             => 'nullable',
        ];
    }
}
