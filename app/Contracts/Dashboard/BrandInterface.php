<?php

namespace App\Contracts\Dashboard;

interface BrandInterface
{
    public function brand();
    public function brandStore($request);
    public function brandUpdate($request, $id);
    public function brandDelete($id);
    public function brandShow($id);
}
