<?php

namespace App\Contracts\Dashboard;

interface CategoryInterface
{
    public function category();
    public function categoryStore($request);
    public function categoryUpdate($request, $id);
    public function categoryDelete($id);
    public function categoryShow($id);
}
