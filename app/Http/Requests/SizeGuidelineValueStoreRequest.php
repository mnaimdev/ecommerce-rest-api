<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SizeGuidelineValueStoreRequest extends FormRequest
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
            'size_guideline_id'           => 'required',
            'size_guideline_label_id'     => 'required',
            'name'                        => 'required',
        ];
    }
}
