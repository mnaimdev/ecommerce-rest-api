<?php

namespace App\Contracts\Dashboard;

interface OrderStatusInterface
{
    public function orderStatus();
    public function orderStatusStore($request);
    public function orderStatusUpdate($request, $id);
    public function orderStatusDelete($id);
    public function orderStatusShow($id);
}
