<?php

namespace App\Contracts\Dashboard;

interface CouponConditionInterface
{
    public function couponCondition();
    public function couponConditionStore($request);
    public function couponConditionUpdate($request, $id);
    public function couponConditionDelete($id);
    public function couponConditionShow($id);
}
