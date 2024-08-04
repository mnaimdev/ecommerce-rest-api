<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\FlashSaleInterface;
use App\Helpers\SendingResponse;
use App\Enums\FlashSaleDiscountTypeEnum;
use App\Enums\ProductTypeEnum;
use App\Models\FlashSale;
use App\Models\FlashSaleProduct;
use App\Models\Product;
use App\Models\ProductVariant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FlashSaleRepository implements FlashSaleInterface
{
    public function flashSale()
    {
        $flashSale = FlashSale::with('flashSaleProduct')->get();
        return SendingResponse::response('success', 'Flash Sale Info', $flashSale, '', 200);
    }


    public function workWithDiscount($request, $discountAmount, $discountType, $baseProduct, $product, $flashSale, $variantId, $productId)
    {
        if (!empty($request->discount_amount) || !empty($discountAmount)) {
            if ($request->discount_type == FlashSaleDiscountTypeEnum::PERCENTAGE->value || $discountType == FlashSaleDiscountTypeEnum::PERCENTAGE->value) {

                $discType = FlashSaleDiscountTypeEnum::PERCENTAGE->value;

                $discountCalc = empty($discountAmount) ? (($baseProduct->regular_price * $request->discount_amount) / 100)
                    : (($baseProduct->regular_price * $discountAmount) / 100);
                $priceAfterDiscount = $baseProduct->regular_price - $discountCalc;

                if ($request->discount_amount > 100 || $discountAmount > 100) {

                    return 'Percentage Error';
                }
            }

            // else if
            else if ($request->discount_type == FlashSaleDiscountTypeEnum::FLAT->value || $discountType == FlashSaleDiscountTypeEnum::FLAT->value) {

                $discType = FlashSaleDiscountTypeEnum::FLAT->value;

                $priceAfterDiscount = empty($discountAmount) ? $baseProduct->regular_price - $request->discount_amount
                    : $baseProduct->regular_price - $discountAmount;

                if ($request->discount_amount > $baseProduct->regular_price || $discountAmount > $baseProduct->regular_price) {
                    return 'Flat Error';
                }
            }

            $this->processFlashSaleProduct($flashSale->id, $productId, $variantId, $discType, $priceAfterDiscount, $baseProduct->stock, $product['offer_stock'], $baseProduct->regular_price);
        }
    }

    public function processFlashSaleProduct($flashSaleId, $productId, $variantId, $discountType, $priceAfterDiscount, $currentStock, $offerStock, $regularPrice)
    {
        FlashSaleProduct::create([
            'flash_sale_id'         => $flashSaleId,
            'product_id'            => $productId,
            'product_variant_id'    => $variantId,
            'regular_price'         => $regularPrice,
            'discount_type'         => $discountType,
            'price_after_discount'  => $priceAfterDiscount,
            'current_stock'         => $currentStock,
            'offer_stock'           => $offerStock,
            'created_at'            => Carbon::now(),
        ]);
    }

    public function flashSaleStore($request)
    {
        try {

            DB::beginTransaction();

            $flashSaleId = FlashSale::insertGetId([
                'name'                  => $request->name,
                'start_date'            => $request->start_date,
                'end_date'              => $request->end_date,
                'status'                => $request->status,
                'created_at'            => Carbon::now(),
            ]);

            $flashSale = FlashSale::findOrFail($flashSaleId);

            // check if product is not empty
            $products = $request->product;
            if (!empty($products)) {
                foreach ($products as $product) {

                    // single product
                    if ($product['product_type'] == ProductTypeEnum::SINGLE->value) {
                        // check current stock
                        $baseProduct = Product::findOrFail($product['product_id']);

                        if ($baseProduct->stock < $product['offer_stock']) {
                            return SendingResponse::handleException('error', 'Offer stock can\'t be greater than current stock');
                            DB::rollBack();
                        }

                        // working with discount type
                        $discountMessage = $this->workWithDiscount($request, $product['discount_amount'], $product['discount_type'], $baseProduct, $product, $flashSale, null, $product['product_id']);

                        if ($discountMessage == 'Percentage Error') {
                            return SendingResponse::handleException('error', 'Discount percentage can\'t be greater than 100');
                            DB::rollBack();
                        } else if ($discountMessage == 'Flat Error') {
                            return SendingResponse::handleException('error', 'Discount price can\'t be greater than regular price');
                            DB::rollBack();
                        }

                        Product::findOrFail($product['product_id'])->update([
                            'flash_sale_id'         => $flashSale->id,
                            'discount_from_date'    => $flashSale->start_date,
                            'discount_to_date'      => $flashSale->end_date,
                        ]);
                    }

                    // if product has variants
                    else if ($product['product_type'] == ProductTypeEnum::MULTIPLE->value) {

                        if (!empty($product['variant'])) {
                            foreach ($product['variant'] as $variant) {

                                // check stock
                                $productVariant = ProductVariant::findOrFail($variant['variant_id']);

                                if ($productVariant->stock < $variant['offer_stock']) {
                                    return SendingResponse::handleException('error', 'Offer stock can\'t be greater than current stock');
                                    DB::rollBack();
                                }

                                $discountMessage = $this->workWithDiscount($request, $variant['discount_amount'], $variant['discount_type'], $productVariant, $variant, $flashSale, $productVariant->id, $product['product_id']);


                                if ($discountMessage == 'Percentage Error') {
                                    return SendingResponse::handleException('error', 'Discount percentage can\'t be greater than 100');
                                    DB::rollBack();
                                } else if ($discountMessage == 'Flat Error') {

                                    return SendingResponse::handleException('error', 'Discount price can\'t be greater than regular price');
                                    DB::rollBack();
                                }

                                ProductVariant::findOrFail($variant['variant_id'])->update([
                                    'flash_sale_id'       => $flashSale->id,
                                    'start_date'          => $flashSale->start_date,
                                    'end_date'            => $flashSale->end_date,
                                ]);
                            }
                        }
                    }
                }

                DB::commit();

                return SendingResponse::response('success', 'Flash Sale Created', $flashSale, '', 200);
            }
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
            DB::rollBack();
        }
    }

    public function flashSaleUpdate($request, $id)
    {
        try {
            DB::beginTransaction();

            $flashSale = FlashSale::findOrFail($id);

            $flashSale->update([
                'name'                  => $request->name,
                'start_date'            => $request->start_date,
                'end_date'              => $request->end_date,
                'status'                => $request->status,
                'created_at'            => Carbon::now(),
            ]);


            // check if product is not empty
            $products = $request->product;
            if (!empty($products)) {

                FlashSaleProduct::where('flash_sale_id', $flashSale->id)->delete();

                ProductVariant::where('flash_sale_id', $flashSale->id)->update([
                    'flash_sale_id'       => null,
                    'start_date'          => null,
                    'end_date'            => null,
                ]);

                Product::where('flash_sale_id', $flashSale->id)->update([
                    'flash_sale_id'         => null,
                    'discount_from_date'    => null,
                    'discount_to_date'      => null,
                ]);

                foreach ($products as $product) {

                    // single product
                    if ($product['product_type'] == ProductTypeEnum::SINGLE->value) {
                        // check current stock
                        $baseProduct = Product::findOrFail($product['product_id']);

                        if ($baseProduct->stock < $product['offer_stock']) {
                            return SendingResponse::handleException('error', 'Offer stock can\'t be greater than current stock');
                            DB::rollBack();
                        }

                        // working with discount type
                        $discountMessage = $this->workWithDiscount($request, $product['discount_amount'], $product['discount_type'], $baseProduct, $product, $flashSale, null, $product['product_id']);


                        if ($discountMessage == 'Percentage Error') {
                            return SendingResponse::handleException('error', 'Discount percentage can\'t be greater than 100');
                            DB::rollBack();
                        } else if ($discountMessage == 'Flat Error') {
                            return SendingResponse::handleException('error', 'Discount price can\'t be greater than regular price');
                            DB::rollBack();
                        }

                        Product::findOrFail($product['product_id'])->update([
                            'flash_sale_id'         => $flashSale->id,
                            'discount_from_date'    => $flashSale->start_date,
                            'discount_to_date'      => $flashSale->end_date,
                        ]);
                    }

                    // if product has variants
                    else if ($product['product_type'] == ProductTypeEnum::MULTIPLE->value) {

                        if (!empty($product['variant'])) {
                            foreach ($product['variant'] as $variant) {

                                // check stock
                                $productVariant = ProductVariant::findOrFail($variant['variant_id']);

                                if ($productVariant->stock < $variant['offer_stock']) {
                                    return SendingResponse::handleException('error', 'Offer stock can\'t be greater than current stock');
                                    DB::rollBack();
                                }

                                $discountMessage = $this->workWithDiscount($request, $variant['discount_amount'], $variant['discount_type'], $productVariant, $variant, $flashSale, $productVariant->id, $product['product_id']);


                                if ($discountMessage == 'Percentage Error') {
                                    return SendingResponse::handleException('error', 'Discount percentage can\'t be greater than 100');
                                    DB::rollBack();
                                } else if ($discountMessage == 'Flat Error') {
                                    return SendingResponse::handleException('error', 'Discount price can\'t be greater than regular price');
                                    DB::rollBack();
                                }

                                ProductVariant::findOrFail($variant['variant_id'])->update([
                                    'flash_sale_id'       => $flashSale->id,
                                    'start_date'          => $flashSale->start_date,
                                    'end_date'            => $flashSale->end_date,
                                ]);
                            }
                        }
                    }
                }
            }

            DB::commit();

            return SendingResponse::response('success', 'Flash Sale Updated', $flashSale, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
            DB::rollBack();
        }
    }

    public function flashSaleDelete($id)
    {
        $flashSale = FlashSale::findOrFail($id);

        ProductVariant::where('flash_sale_id', $flashSale->id)->update([
            'flash_sale_id'       => null,
            'start_date'          => null,
            'end_date'            => null,
        ]);

        Product::where('flash_sale_id', $flashSale->id)->update([
            'flash_sale_id'         => null,
            'discount_from_date'    => null,
            'discount_to_date'      => null,
        ]);

        $flashSale->delete();

        return SendingResponse::response('success', 'Flash Sale Deleted', '', '', 200);
    }

    public function flashSaleShow($id)
    {
        $flashSale = FlashSale::with(['flashSaleProduct'])->findOrFail($id);

        return SendingResponse::response('success', 'Flash Sale', $flashSale, '', 200);
    }
}
