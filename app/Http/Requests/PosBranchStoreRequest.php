<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PosBranchStoreRequest extends FormRequest
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
            'branch_name'           => 'required|unique:pos_branches,branch_name',
            'branch_location'       => 'required',
            'latitude'              => 'nullable',
            'longitude'             => 'nullable',
            'status'                => 'nullable',
        ];
    }
}
