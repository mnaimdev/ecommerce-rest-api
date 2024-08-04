<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\DeliveryChargeSettingInterface;
use App\Enums\DeliveryFeeTypeEnum;
use App\Helpers\SendingResponse;
use App\Models\DeliveryChargeSetting;
use App\Models\DeliveryRule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DeliveryChargeSettingRepository implements DeliveryChargeSettingInterface
{
    public function deliveryChargeSetting()
    {
        $deliveryChargeSetting = DeliveryChargeSetting::with(['deliveryRules'])->get();
        return SendingResponse::response('success', 'Delivery Charge Setting Info', $deliveryChargeSetting, '', 200);
    }

    public function deliveryChargeSettingStore($request)
    {
        try {
            DB::beginTransaction();

            // working with delivery fee type
            if ($request->delivery_fee_type == DeliveryFeeTypeEnum::FLATDELIVERY->value) {
                $deliveryFeeType = DeliveryFeeTypeEnum::FLATDELIVERY->value;
            } else if ($request->delivery_fee_type == DeliveryFeeTypeEnum::LOCATION->value) {
                $deliveryFeeType = DeliveryFeeTypeEnum::LOCATION->value;
            }

            $deliveryChargeSetting = DeliveryChargeSetting::create([
                'title'                 => $request->title,
                'delivery_fee_type'     => $deliveryFeeType,
                'created_at'            => Carbon::now(),
            ]);


            // insert data into product variant
            if (!empty($request->rules)) {
                foreach ($request->rules as $rule) {
                    DeliveryRule::create([
                        'delivery_charge_setting_id'    => $deliveryChargeSetting->id,
                        'country_id'                    => $rule['country_id'],
                        'state_id'                      => $rule['state_id'],
                        'city_id'                       => $rule['city_id'],
                        'delivery_charge'               => $rule['delivery_charge'],
                        'is_delivery_charge_free'       => $rule['is_delivery_charge_free'],
                        'free_delivery_order_amount'    => $rule['free_delivery_order_amount'],
                        'status'                        => $rule['status'],
                    ]);
                }
            }

            DB::commit();

            return SendingResponse::response('success', 'Delivery Charge Setting Created', $deliveryChargeSetting, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
            DB::rollBack();
        }
    }

    public function deliveryChargeSettingUpdate($request, $id)
    {
        try {
            DB::beginTransaction();

            $deliveryChargeSetting = DeliveryChargeSetting::findOrFail($id);

            // working with delivery fee type
            if ($request->delivery_fee_type == DeliveryFeeTypeEnum::FLATDELIVERY->value) {
                $deliveryFeeType = DeliveryFeeTypeEnum::FLATDELIVERY->value;
            } else if ($request->delivery_fee_type == DeliveryFeeTypeEnum::LOCATION->value) {
                $deliveryFeeType = DeliveryFeeTypeEnum::LOCATION->value;
            }

            $deliveryChargeSetting->update([
                'title'                 => $request->title,
                'delivery_fee_type'     => $deliveryFeeType,
            ]);

            // insert data into product variant
            if (!empty($request->rules)) {
                DeliveryRule::where('delivery_charge_setting_id', $deliveryChargeSetting->id)->delete();

                foreach ($request->rules as $rule) {
                    DeliveryRule::create([
                        'delivery_charge_setting_id'    => $deliveryChargeSetting->id,
                        'country_id'                    => $rule['country_id'],
                        'state_id'                      => $rule['state_id'],
                        'city_id'                       => $rule['city_id'],
                        'delivery_charge'               => $rule['delivery_charge'],
                        'is_delivery_charge_free'       => $rule['is_delivery_charge_free'],
                        'free_delivery_order_amount'    => $rule['free_delivery_order_amount'],
                        'status'                        => $rule['status'],
                    ]);
                }
            }

            DB::commit();

            return SendingResponse::response('success', 'Delivery Charge Setting Updated', $deliveryChargeSetting, '', 200);
        } catch (\Exception $e) {
            return SendingResponse::handleException('error', $e->getMessage());
            DB::rollBack();
        }
    }

    public function deliveryChargeSettingDelete($id)
    {
        $deliveryChargeSetting = DeliveryChargeSetting::findOrFail($id);

        $deliveryChargeSetting->delete();

        return SendingResponse::response('success', 'Delivery Charge Setting Deleted', '', '', 200);
    }

    public function deliveryChargeSettingShow($id)
    {
        $deliveryChargeSetting = DeliveryChargeSetting::with(['deliveryRules'])->findOrFail($id);

        return SendingResponse::response('success', 'Delivery Charge Setting', $deliveryChargeSetting, '', 200);
    }
}
