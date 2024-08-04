<?php

namespace App\Contracts\Dashboard;

interface FlashSaleInterface
{
    public function flashSale();
    public function flashSaleStore($request);
    public function flashSaleUpdate($request, $id);
    public function flashSaleDelete($id);
    public function flashSaleShow($id);
}
