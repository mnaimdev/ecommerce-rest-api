<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\ProductInterface;
use App\Enums\ProductStatusEnum;
use App\Helpers\ImageHelper;
use App\Helpers\SendingResponse;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\FakeCounter;
use App\Models\FaqProduct;
use App\Models\FrequentlyBuyProduct;
use App\Models\LabelProduct;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductShipping;
use App\Models\ProductTag;
use App\Models\ProductVariant;
use App\Models\RelatedProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductInterface
{
    public function product()
    {
        $products = Product::with(['user', 'brand', 'flashSale', 'taxSetting'])->get();
        return SendingResponse::response('success', 'Product Info', $products, '', 200);
    }

    public function productStore($request)
    {
        try {
            DB::beginTransaction();

            // working with status
            if ($request->status == ProductStatusEnum::PUBLISHED->value) {
                $productStatus = ProductStatusEnum::PUBLISHED->value;
            } else if ($request->status == ProductStatusEnum::DRAFT->value) {
                $productStatus = ProductStatusEnum::DRAFT->value;
            } else if ($request->status == ProductStatusEnum::UNPUBLISHED->value) {
                $productStatus = ProductStatusEnum::UNPUBLISHED->value;
            }

            $productId = Product::insertGetId([
                'name'                  => $request->name,
                'slug'                  => $request->slug,
                'short_description'     => $request->short_description,
                'long_description'      => $request->long_description,
                'stock'                 => $request->stock,
                'stock_status'          => $request->stock_status,
                'sku'                   => $request->sku,
                'regular_price'         => $request->regular_price,
                'sale_price'            => $request->sale_price,
                'cost_of_goods'         => $request->cost_of_goods,
                'discount'              => $request->discount,
                'discount_from_date'    => $request->discount_from_date,
                'discount_to_date'      => $request->discount_to_date,
                'meta_title'            => $request->meta_title,
                'meta_description'      => $request->meta_description,
                'is_featured_Product'   => $request->is_featured_product,
                'is_single_product'     => $request->is_single_product,
                'user_id'               => $request->user()->id,
                'brand_id'              => $request->brand_id,
                'flash_sale_id'         => $request->flash_sale_id,
                'tax_id'                => $request->tax_setting_id,
                'status'                => $productStatus,
                'vat'                   => $request->vat,
                'low_stock_threshold'   => $request->low_stock_threshold,
                "size_guideline_id"     => $request->size_guideline_id,
                'created_at'            => Carbon::now(),
            ]);

            $product = Product::findOrFail($productId);

            $product->categories()->attach($request->category_id);
            $product->labels()->attach($request->label_id);
            $product->tags()->attach($request->tag_id);
            $product->faqs()->attach($request->faq_id);


            // insert data into product shipping
            if ($request->width != '' || $request->height != '' || $request->weight != '' || $request->length != '') {
                ProductShipping::create([
                    'product_id' => $product->id,
                    'user_id'    => $request->user()->id,
                    'width'      => $request->width,
                    'height'     => $request->height,
                    'length'     => $request->length,
                ]);
            }

            // insert data into related product
            if (!empty($request->related_product_id)) {
                foreach ($request->related_product_id as $relatedProductId) {
                    RelatedProduct::create([
                        'related_product_id'            => $relatedProductId,
                        'product_id'                    => $product->id,
                    ]);
                }
            }

            // insert data into frequently buy product
            $frequentlyBuyProducts = $request->frequently_buy_product;
            if (!empty($frequentlyBuyProducts)) {
                foreach ($frequentlyBuyProducts as $frequentlyBuyProduct) {
                    FrequentlyBuyProduct::create([
                        'frequently_buy_product_id'     => $frequentlyBuyProduct['frequently_buy_product_id'],
                        'product_id'                    => $product->id,
                        'discount'                      => $frequentlyBuyProduct['discount'],
                    ]);
                }
            }

            // insert data into fake counter
            $fakeCounters = $request->fake_counter;
            if (!empty($fakeCounters)) {
                foreach ($fakeCounters as $fakeCounter) {
                    FakeCounter::create([
                        'product_id'            => $product->id,
                        'name'                  => $fakeCounter['name'],
                        'min_value'             => $fakeCounter['min_value'],
                        'max_value'             => $fakeCounter['max_value']
                    ]);
                }
            }

            // insert data into product variant
            if (!empty($request->product_variant)) {
                foreach ($request->product_variant as $productVariant) {
                    $productVariantId = ProductVariant::insertGetId([
                        'product_id'                => $product->id,
                        'attribute_name_id'         => $productVariant['attribute_name_id'],
                        'attribute_value_id'        => $productVariant['attribute_value_id'],
                        'stock'                     => $productVariant['stock'],
                        'stock_status'              => $productVariant['stock_status'],
                        'sku'                       => $productVariant['sku'],
                        'regular_price'             => $productVariant['regular_price'],
                        'sale_price'                => $productVariant['sale_price'],
                        'discount'                  => $productVariant['discount'],
                        'start_date'                => $productVariant['start_date'],
                        'end_date'                  => $productVariant['end_date'],
                        'low_stock_threshold'       => $productVariant['low_stock_threshold'],
                    ]);

                    if ($productVariant['image'] != '') {
                        $productVariantImage = ImageHelper::saveImage($productVariant['image'], '/uploads/product/variant/');
                        ProductVariant::findOrFail($productVariantId)->update([
                            'image' => $productVariantImage,
                        ]);
                    }
                }

                $product->update([
                    'is_single_product' => 0,
                ]);
            }

            // insert data into product images
            $productImages = $request->image;
            if (!empty($productImages)) {
                foreach ($productImages as $productImage) {
                    $image = ImageHelper::saveImage($productImage['image'], '/uploads/product/image/');

                    ProductImage::create([
                        'product_id'    => $product->id,
                        'image'         => $image,
                        'is_thumbnail'  => $productImage['is_thumbnail'],
                    ]);

                    // check if is thumbnail true
                    if ($productImage['is_thumbnail'] == 1) {
                        $thumbnailImage = ImageHelper::saveImage($productImage['image'], '/uploads/product/');
                        // processing thumbnail
                        $product->update([
                            'thumbnail_image'   => $thumbnailImage,
                        ]);
                    }
                }
            }

            DB::commit();

            return SendingResponse::response('success', 'Product Created', $product, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
            DB::rollBack();
        }
    }

    public function productUpdate($request, $id)
    {
        try {
            DB::beginTransaction();

            $product = Product::findOrFail($id);

            // working with status
            if ($request->status == ProductStatusEnum::PUBLISHED->value) {
                $productStatus = ProductStatusEnum::PUBLISHED->value;
            } else if ($request->status == ProductStatusEnum::DRAFT->value) {
                $productStatus = ProductStatusEnum::DRAFT->value;
            } else if ($request->status == ProductStatusEnum::UNPUBLISHED->value) {
                $productStatus = ProductStatusEnum::UNPUBLISHED->value;
            }

            $product->update([
                'name'                  => $request->name,
                'slug'                  => $request->slug,
                'short_description'     => $request->short_description,
                'long_description'      => $request->long_description,
                'stock'                 => $request->stock,
                'stock_status'          => $request->stock_status,
                'sku'                   => $request->sku,
                'regular_price'         => $request->regular_price,
                'sale_price'            => $request->sale_price,
                'cost_of_goods'         => $request->cost_of_goods,
                'discount'              => $request->discount,
                'discount_from_date'    => $request->discount_from_date,
                'discount_to_date'      => $request->discount_to_date,
                'meta_title'            => $request->meta_title,
                'meta_description'      => $request->meta_description,
                'is_featured_Product'   => $request->is_featured_product,
                'is_single_product'     => $request->is_single_product,
                'user_id'               => $request->user()->id,
                'brand_id'              => $request->brand_id,
                'flash_sale_id'         => $request->flash_sale_id,
                'tax_id'                => $request->tax_setting_id,
                'status'                => $productStatus,
                'vat'                   => $request->vat,
                'low_stock_threshold'   => $request->low_stock_threshold,
                "size_guideline_id"     => $request->size_guideline_id
            ]);

            $product->categories()->sync($request->category_id);
            $product->labels()->sync($request->label_id);
            $product->tags()->sync($request->tag_id);
            $product->faqs()->sync($request->faq_id);

            // insert data into product shipping
            if ($request->width != '' || $request->height != '' || $request->weight != '' || $request->length != '') {
                ProductShipping::where('product_id', $product->id)->delete();

                ProductShipping::Create([
                    'product_id' => $product->id,
                    'user_id'    => $request->user()->id,
                    'width'      => $request->width,
                    'height'     => $request->height,
                    'length'     => $request->length,
                ]);
            }

            // insert data into related product
            if (!empty($request->related_product_id)) {
                RelatedProduct::where('product_id', $product->id)->delete();

                foreach ($request->related_product_id as $relatedProductId) {
                    RelatedProduct::create([
                        'related_product_id'       => $relatedProductId,
                        'product_id'               => $product->id,
                    ]);
                }
            }

            // insert data into frequently buy product
            $frequentlyBuyProducts = $request->frequently_buy_product;
            if (!empty($frequentlyBuyProducts)) {
                FrequentlyBuyProduct::where('product_id', $product->id)->delete();

                foreach ($frequentlyBuyProducts as $frequentlyBuyProduct) {
                    FrequentlyBuyProduct::create([
                        'frequently_buy_product_id'     => $frequentlyBuyProduct['frequently_buy_product_id'],
                        'product_id'                    => $product->id,
                        'discount'                      => $frequentlyBuyProduct['discount'],
                    ]);
                }
            }

            // insert data into fake counter
            $fakeCounters = $request->fake_counter;
            if (!empty($fakeCounters)) {
                FakeCounter::where('product_id', $product->id)->delete();

                foreach ($fakeCounters as $fakeCounter) {
                    FakeCounter::create([
                        'product_id'            => $product->id,
                        'name'                  => $fakeCounter['name'],
                        'min_value'             => $fakeCounter['min_value'],
                        'max_value'             => $fakeCounter['max_value']
                    ]);
                }
            }

            // insert data into product variant
            if (!empty($request->product_variant)) {

                // remove previous product varinat
                $previousProductVariants = ProductVariant::where('product_id', $product->id)->get();
                foreach ($previousProductVariants as $previousProductVariant) {
                    if ($previousProductVariant->image != '') {
                        ImageHelper::removeImage($previousProductVariant->image);
                    }
                }
                ProductVariant::where('product_id', $product->id)->delete();

                foreach ($request->product_variant as $productVariant) {
                    $productVariantId = ProductVariant::insertGetId([
                        'product_id'                => $product->id,
                        'attribute_name_id'         => $productVariant['attribute_name_id'],
                        'attribute_value_id'        => $productVariant['attribute_value_id'],
                        'stock'                     => $productVariant['stock'],
                        'stock_status'              => $productVariant['stock_status'],
                        'sku'                       => $productVariant['sku'],
                        'regular_price'             => $productVariant['regular_price'],
                        'sale_price'                => $productVariant['sale_price'],
                        'discount'                  => $productVariant['discount'],
                        'start_date'                => $productVariant['start_date'],
                        'end_date'                  => $productVariant['end_date'],
                        'low_stock_threshold'       => $productVariant['low_stock_threshold'],
                    ]);

                    if ($productVariant['image'] != '') {
                        $productVariantImage = ImageHelper::saveImage($productVariant['image'], '/uploads/product/variant/');
                        ProductVariant::findOrFail($productVariantId)->update([
                            'image' => $productVariantImage,
                        ]);
                    }
                }

                $product->update([
                    'is_single_product' => 0,
                ]);
            }

            // insert data into product images
            $productImages = $request->image;
            if (!empty($productImages)) {

                // remove previous image if they stay
                $productGalleries = ProductImage::where('product_id', $product->id)->get();
                foreach ($productGalleries as $gallery) {
                    if ($gallery->image != '') {
                        ImageHelper::removeImage($gallery->image);
                    }
                }

                ProductImage::where('product_id', $product->id)->delete();

                foreach ($productImages as $productImage) {
                    // processing new image
                    $image = ImageHelper::saveImage($productImage['image'], '/uploads/product/image/');

                    ProductImage::create([
                        'product_id'    => $product->id,
                        'image'         => $image,
                        'is_thumbnail'  => $productImage['is_thumbnail'],
                    ]);

                    // check if is thumbnail true
                    if ($productImage['is_thumbnail'] == 1) {
                        // remove previous image if they stay
                        if ($product->thumbnail_image != '') {
                            ImageHelper::removeImage($product->thumbnail_image);
                        }

                        $thumbnailImage = ImageHelper::saveImage($productImage['image'], '/uploads/product/');
                        // processing thumbnail
                        $product->update([
                            'thumbnail_image'   => $thumbnailImage,
                        ]);
                    }
                }
            }

            DB::commit();

            return SendingResponse::response('success', 'Product Updated', $product, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
            DB::rollBack();
        }
    }

    public function productDelete($id)
    {
        $product = Product::findOrFail($id);

        if ($product->thumbnail_image != '') {
            ImageHelper::removeImage($product->thumbnail_image);
        }

        // remove product gallery image
        $productGalleries = ProductImage::where('product_id', $product->id)->get();
        foreach ($productGalleries as $gallery) {
            if ($gallery->image != '') {
                ImageHelper::removeImage($gallery->image);
            }
        }

        // remove product variant
        $previousProductVariants = ProductVariant::where('product_id', $product->id)->get();
        foreach ($previousProductVariants as $previousProductVariant) {
            if ($previousProductVariant->image != '') {
                ImageHelper::removeImage($previousProductVariant->image);
            }
        }

        $product->delete();

        return SendingResponse::response('success', 'Product Deleted', '', '', 200);
    }

    public function productShow($id)
    {
        $product = Product::findOrFail($id);

        return SendingResponse::response('success', 'Product', $product, '', 200);
    }

    public function searchProduct($request)
    {

        $request->validate([
            'search'            => 'required',
            'category_id'       => 'nullable',
        ]);

        if (!empty($request->category_id)) {
            $searchProduct = Product::where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('short_description', 'LIKE', '%' . $request->search . '%')
                ->orWhere('long_description', 'LIKE', '%' . $request->search . '%')

                ->whereHas('categories', function ($query) use ($request) {
                    $query->where(['category_id' => $request->category_id, 'product_id' => $searchProduct->id])->get();
                })
                ->get();
        } else {
            $product = Product::where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('short_description', 'LIKE', '%' . $request->search . '%')
                ->orWhere('long_description', 'LIKE', '%' . $request->search . '%')
                ->get();
        }

        return SendingResponse::response('success', 'Product', $product, '', 200);
    }
}
