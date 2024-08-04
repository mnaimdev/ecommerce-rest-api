<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'slug'                  => 'required|unique:products,slug',
            'brand_id'              => 'required',
            'tax_id'                => 'nullable',
            'flash_sale_id'         => 'nullable',
            'short_description'     => 'nullable',
            'long_description'      => 'nullable',
            'stock'                 => 'nullable',
            'stock_status'          => 'nullable',
            'sku'                   => 'required',
            'thumbnail_image'       => 'nullable',
            'regular_price'         => 'nullable',
            'sale_price'            => 'nullable',
            'cost_of_goods'         => 'nullable',
            'discount'              => 'nullable',
            'discount_from_date'    => 'nullable',
            'discount_to_date'      => 'nullable',
            'meta_title'            => 'nullable',
            'meta_description'      => 'nullable',
            'is_featured_product'   => 'nullable',
            'is_single_product'     => 'nullable',
            'status'                => 'required',
            'category_id'           => 'nullable',
            'tag_id'                => 'nullable',
            'size_guideline_id'     => 'nullable',
            'low_stock_threshold'   => 'nullable',
            'vat'                   => 'nullable',
        ];
    }
}
