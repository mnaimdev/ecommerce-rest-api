<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\CouponConditionInterface;
use App\Contracts\Dashboard\CouponInterface;
use App\Enums\CouponCustomerEnum;
use App\Enums\CouponDiscountTypeEnum;
use App\Helpers\SendingResponse;
use App\Models\Coupon;
use App\Models\CouponCustomer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CouponRepository implements CouponInterface
{
    public function coupon()
    {
        $coupon = Coupon::all();
        return SendingResponse::response('success', 'Coupon Info', $coupon, '', 200);
    }

    public function couponStore($request)
    {
        // working with discount type
        if ($request->discount_type == CouponDiscountTypeEnum::PERCENTAGE->value) {
            $discountType = CouponDiscountTypeEnum::PERCENTAGE->value;
        } else if ($request->discount_type == CouponDiscountTypeEnum::FIXED->value) {
            $discountType = CouponDiscountTypeEnum::FIXED->value;
        } else if ($request->discount_type == CouponDiscountTypeEnum::FREESHIPPING->value) {
            $discountType = CouponDiscountTypeEnum::FREESHIPPING->value;
        }

        $couponId = Coupon::insertGetId([
            'name'                              => $request->name,
            'code'                              => $request->code,
            'discount_type'                     => $discountType,
            'discount_amount'                   => $request->discount_amount,
            'usages_limit'                      => $request->usages_limit,
            'number_of_use'                     => $request->number_of_use,
            'start_date'                        => $request->start_date,
            'expire_date'                       => $request->expire_date,
            'min_order_amount'                  => $request->min_order_amount,
            'max_order_amount'                  => $request->max_order_amount,
            'message'                           => $request->message,
            'status'                            => $request->status,
            'coupon_condition_id'               => $request->coupon_condition_id,
            'user_id'                           => $request->user()->id,
            'created_at'                        => Carbon::now(),
        ]);

        $coupon = Coupon::findOrFail($couponId);

        $coupon->products()->attach($request->product_id);
        $coupon->categories()->attach($request->category_id);

        $couponCustomers = $request->coupon_customer;
        if (!empty($couponCustomers)) {
            foreach ($couponCustomers as $couponCustomer) {
                // working with coupon usages time
                if ($couponCustomer['usages_time'] == CouponCustomerEnum::SINGLE->value) {
                    $couponUsagesTime = CouponCustomerEnum::SINGLE->value;
                } else if ($couponCustomer['usages_time'] == CouponCustomerEnum::MULTIPLE->value) {
                    $couponUsagesTime = CouponCustomerEnum::MULTIPLE->value;
                }

                CouponCustomer::create([
                    'user_id'           => $couponCustomer['user_id'],
                    'usages_time'       => $couponUsagesTime,
                    'coupon_id'         => $coupon->id,
                ]);
            }
        }

        return SendingResponse::response('success', 'Coupon Created', $coupon, '', 200);
    }

    public function couponUpdate($request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        // working with discount type
        if ($request->discount_type == CouponDiscountTypeEnum::PERCENTAGE->value) {
            $discountType = CouponDiscountTypeEnum::PERCENTAGE->value;
        } else if ($request->discount_type == CouponDiscountTypeEnum::FIXED->value) {
            $discountType = CouponDiscountTypeEnum::FIXED->value;
        } else if ($request->discount_type == CouponDiscountTypeEnum::FREESHIPPING->value) {
            $discountType = CouponDiscountTypeEnum::FREESHIPPING->value;
        }

        $coupon->update([
            'name'                              => $request->name,
            'code'                              => $request->code,
            'discount_type'                     => $discountType,
            'discount_amount'                   => $request->discount_amount,
            'usages_limit'                      => $request->usages_limit,
            'number_of_use'                     => $request->number_of_use,
            'start_date'                        => $request->start_date,
            'expire_date'                       => $request->expire_date,
            'min_order_amount'                  => $request->min_order_amount,
            'max_order_amount'                  => $request->max_order_amount,
            'message'                           => $request->message,
            'status'                            => $request->status,
            'coupon_condition_id'               => $request->coupon_condition_id,
            'user_id'                           => $request->user()->id,
        ]);

        $coupon->products()->sync($request->product_id);
        $coupon->categories()->sync($request->category_id);

        $couponCustomers = $request->coupon_customer;
        if (!empty($couponCustomers)) {

            CouponCustomer::where('coupon_id', $coupon->id)->delete();

            foreach ($couponCustomers as $couponCustomer) {
                // working with coupon usages time
                if ($couponCustomer['usages_time'] == CouponCustomerEnum::SINGLE->value) {
                    $couponUsagesTime = CouponCustomerEnum::SINGLE->value;
                } else if ($couponCustomer['usages_time'] == CouponCustomerEnum::MULTIPLE->value) {
                    $couponUsagesTime = CouponCustomerEnum::MULTIPLE->value;
                }

                CouponCustomer::create([
                    'user_id'           => $couponCustomer['user_id'],
                    'usages_time'       => $couponUsagesTime,
                    'coupon_id'         => $coupon->id,
                ]);
            }
        }

        return SendingResponse::response('success', 'Coupon Updated', $coupon, '', 200);
    }

    public function couponDelete($id)
    {
        $coupon = Coupon::findOrFail($id);

        $coupon->delete();

        return SendingResponse::response('success', 'Coupon Deleted', '', '', 200);
    }

    public function couponShow($id)
    {
        $coupon = Coupon::findOrFail($id);

        return SendingResponse::response('success', 'Coupon', $coupon, '', 200);
    }
}
