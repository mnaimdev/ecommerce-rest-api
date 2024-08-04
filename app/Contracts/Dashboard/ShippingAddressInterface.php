<?php

namespace App\Contracts\Dashboard;

interface ShippingAddressInterface
{
    public function shippingAddress();
    public function shippingAddressStore($request);
    public function shippingAddressUpdate($request, $id);
    public function shippingAddressDelete($id);
    public function shippingAddressShow($id);
}
