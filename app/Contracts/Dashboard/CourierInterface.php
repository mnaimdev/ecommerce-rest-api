<?php

namespace App\Contracts\Dashboard;

interface CourierInterface
{
    public function courier();
    public function courierStore($request);
    public function courierUpdate($request, $id);
    public function courierDelete($id);
    public function courierShow($id);
}
