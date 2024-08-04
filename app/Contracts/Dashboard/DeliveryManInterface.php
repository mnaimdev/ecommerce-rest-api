<?php

namespace App\Contracts\Dashboard;

interface DeliveryManInterface
{
    public function deliveryMan();
    public function deliveryManStore($request);
    public function deliveryManUpdate($request, $id);
    public function deliveryManDelete($id);
    public function deliveryManShow($id);
}
