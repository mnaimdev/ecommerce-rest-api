<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\CouponConditionInterface;
use App\Helpers\SendingResponse;
use App\Models\CouponCondition;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CouponConditionRepository implements CouponConditionInterface
{
    public function couponCondition()
    {
        $couponCondition = CouponCondition::all();
        return SendingResponse::response('success', 'Coupon Condition Info', $couponCondition, '', 200);
    }

    public function couponConditionStore($request)
    {
        $couponCondition = CouponCondition::create([
            'title'                  => $request->title,
            'slug'                   => $request->slug,
            'status'                 => $request->status,
            'created_at'             => Carbon::now(),
        ]);

        return SendingResponse::response('success', 'Coupon Condition Created', $couponCondition, '', 200);
    }

    public function couponConditionUpdate($request, $id)
    {
        $couponCondition = CouponCondition::findOrFail($id);

        $couponCondition->update([
            'title'                  => $request->title,
            'slug'                   => $request->slug,
            'status'                 => $request->status,
        ]);

        return SendingResponse::response('success', 'Coupon Condition Updated', $couponCondition, '', 200);
    }

    public function couponConditionDelete($id)
    {
        $couponCondition = CouponCondition::findOrFail($id);

        $couponCondition->delete();

        return SendingResponse::response('success', 'Coupon Condition Deleted', '', '', 200);
    }

    public function couponConditionShow($id)
    {
        $couponCondition = CouponCondition::findOrFail($id);

        return SendingResponse::response('success', 'Coupon Condition', $couponCondition, '', 200);
    }
}
