<?php

namespace App\Contracts\Dashboard;

interface LabelInterface
{
    public function label();
    public function labelStore($request);
    public function labelUpdate($request, $id);
    public function labelDelete($id);
    public function labelShow($id);
}
