<?php

namespace App\Contracts\Dashboard;

interface DeliveryChargeSettingInterface
{
    public function deliveryChargeSetting();
    public function deliveryChargeSettingStore($request);
    public function deliveryChargeSettingUpdate($request, $id);
    public function deliveryChargeSettingDelete($id);
    public function deliveryChargeSettingShow($id);
}
