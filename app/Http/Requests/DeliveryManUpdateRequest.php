<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryManUpdateRequest extends FormRequest
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
            'name'                          => 'required',
            'email'                         => 'required',
            'phone'                         => 'required',
            'nid_number'                    => 'nullable',
            'nid_image'                     => 'nullable',
            'passport_number'               => 'nullable',
            'passport_image'                => 'nullable',
            'address'                       => 'required',
            'reference_id'                  => 'nullable',
            'reference_name'                => 'nullable',
            'reference_address'             => 'nullable',
            'reference_nid'                 => 'nullable',
            'reference_phone'               => 'nullable',
            'reference_passport_number'     => 'nullable',
            'status'                        => 'nullable',
            'profile_picture'               => 'nullable',
        ];
    }
}
