<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlashSaleUpdateRequest extends FormRequest
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
            'name'                  => 'required',
            'start_date'            => 'required',
            'end_date'              => 'required',
            'status'                => 'required',
            'product_id'            => 'nullable',
            'regular_price'         => 'nullable',
            'discount_type'         => 'nullable',
            'after_discount_price'  => 'nullable',
            'current_stock'         => 'nullable',
            'offer_stock'           => 'nullable',
        ];
    }
}
