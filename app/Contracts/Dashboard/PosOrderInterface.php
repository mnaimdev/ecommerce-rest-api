<?php

namespace App\Contracts\Dashboard;

interface PosOrderInterface
{
    public function posOrder();
    public function posOrderStore($request);
    public function posOrderUpdate($request, $id);
    public function posOrderDelete($id);
    public function posOrderShow($id);
}
