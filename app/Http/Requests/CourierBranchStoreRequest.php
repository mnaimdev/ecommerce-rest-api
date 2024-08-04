<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourierBranchStoreRequest extends FormRequest
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
            'courier_id'                        => 'required',
            'branch_name'                       => 'required|unique:courier_branches,branch_name',
            'branch_location'                   => 'required',
            'branch_latitude'                   => 'nullable',
            'branch_longitude'                  => 'nullable',
            'merchant_account_no'               => 'nullable',
            'contact_person_one_name'           => 'nullable',
            'contact_person_one_phone'          => 'nullable',
            'contact_person_two_name'           => 'nullable',
            'contact_person_two_phone'          => 'nullable',
            'status'                            => 'nullable',
        ];
    }
}
