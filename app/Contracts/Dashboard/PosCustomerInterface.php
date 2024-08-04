<?php

namespace App\Contracts\Dashboard;

interface PosCustomerInterface
{
    public function posCustomer();
    public function posCustomerStore($request);
    public function posCustomerUpdate($request, $id);
    // public function posCustomerDelete($id);
    public function posCustomerShow($id);
    public function searchCustomer($request);
}
