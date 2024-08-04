<?php

namespace App\Contracts\Dashboard;

interface ProductInterface
{
    public function product();
    public function productStore($request);
    public function productUpdate($request, $id);
    public function productDelete($id);
    public function productShow($id);
    public function searchProduct($request);
}
