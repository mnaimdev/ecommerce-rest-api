<?php

namespace App\Contracts\Dashboard;

interface CustomerInterface
{
    public function customer();
    public function customerStore($request);
    public function customerUpdate($request, $id);
    public function customerDelete($id);
    public function customerShow($id);
}
