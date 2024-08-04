<?php

namespace App\Contracts\Dashboard;

interface SocialShopInterface
{
    public function socialShop();
    public function socialShopStore($request);
    public function socialShopUpdate($request, $id);
    public function socialShopDelete($id);
    public function socialShopShow($id);
}
