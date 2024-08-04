<?php

namespace App\Contracts\Dashboard;

interface CouponInterface
{
    public function coupon();
    public function couponStore($request);
    public function couponUpdate($request, $id);
    public function couponDelete($id);
    public function couponShow($id);
}
