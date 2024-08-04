<?php

namespace App\Repositories\Dashboard;

use App\Contracts\Dashboard\ShippingAddressInterface;
use App\Helpers\ImageHelper;
use App\Helpers\SendingResponse;
use App\Models\ShippingAddress;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ShippingAddressRepository implements ShippingAddressInterface
{
    public function shippingAddress()
    {
        $shippingAddress = ShippingAddress::all();
        return SendingResponse::response('success', 'Shipping Address Info', $shippingAddress, '', 200);
    }

    public function shippingAddressStore($request)
    {
        $shippingAddressId = ShippingAddress::insertGetId([
            'customer_id'           => $request->customer_id,
            'phone'                 => $request->phone,
            'alternative_phone'     => $request->alternative_phone,
            'email'                 => $request->email,
            'country_id'            => $request->country_id,
            'state_id'              => $request->state_id,
            'city_id'               => $request->city_id,
            'address'               => $request->address,
            'latitude'              => $request->latitude,
            'longitude'             => $request->longitude,
            'status'                => $request->status,
            'created_at'            => Carbon::now(),
        ]);

        $shippingAddress = ShippingAddress::findOrFail($shippingAddressId);

        return SendingResponse::response('success', 'Shipping Address Created', $shippingAddress, '', 200);
    }

    public function shippingAddressUpdate($request, $id)
    {
        $shippingAddress = ShippingAddress::findOrFail($id);

        $shippingAddress->update([
            'customer_id'           => $request->customer_id,
            'phone'                 => $request->phone,
            'alternative_phone'     => $request->alternative_phone,
            'email'                 => $request->email,
            'country_id'            => $request->country_id,
            'state_id'              => $request->state_id,
            'city_id'               => $request->city_id,
            'address'               => $request->address,
            'latitude'              => $request->latitude,
            'longitude'             => $request->longitude,
            'status'                => $request->status,
        ]);

        return SendingResponse::response('success', 'Shipping Address Updated', $shippingAddress, '', 200);
    }

    public function shippingAddressDelete($id)
    {
        $shippingAddress = ShippingAddress::findOrFail($id);

        $shippingAddress->delete();

        return SendingResponse::response('success', 'Shipping Address Deleted', '', '', 200);
    }

    public function shippingAddressShow($id)
    {
        $shippingAddress = ShippingAddress::findOrFail($id);
        return SendingResponse::response('success', 'Shipping Address', $shippingAddress, '', 200);
    }
}
