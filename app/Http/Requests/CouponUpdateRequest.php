<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponUpdateRequest extends FormRequest
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
            'coupon_condition_id'   => 'required',
            'name'                  => 'required',
            'code'                  => 'required',
            'discount_type'         => 'nullable',
            'discount_amount'       => 'nullable',
            'usages_limit'          => 'nullable',
            'number_of_use'         => 'nullable',
            'start_date'            => 'nullable',
            'expire_date'           => 'nullable',
            'min_order_amount'      => 'nullable',
            'max_order_amount'      => 'nullable',
            'message'               => 'nullable',
            'status'                => 'required',
        ];
    }
}
