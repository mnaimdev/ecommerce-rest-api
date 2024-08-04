<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PosOrderStoreRequest extends FormRequest
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
            'customer_id'               => 'required',
            'admin_id'                  => 'nullable',
            'coupon_id'                 => 'nullable',
            'pos_branch_id'             => 'nullable',
            'social_shop_id'            => 'nullable',
            'order_status_id'           => 'nullable',
            'customer_type'             => 'required',
            'transaction_no'            => 'nullable',
            'invoice_no'                => 'nullable',
            'delivery_type'             => 'nullable',
            'delivery_charge_id'        => 'nullable',
            'delivery_date'             => 'nullable',
            'subtotal'                  => 'required',
            'delivery_charge'           => 'nullable',
            'tax_amount'                => 'nullable',
            'discount_amount'           => 'nullable',
            'total_amount'              => 'nullable',
            'note'                      => 'nullable',
            'print_status'              => 'nullable',
            'print_count'               => 'nullable',
        ];
    }
}
