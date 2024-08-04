<?php

namespace App\Contracts\Dashboard;

interface CourierBranchInterface
{
    public function courierBranch();
    public function courierBranchStore($request);
    public function courierBranchUpdate($request, $id);
    public function courierBranchDelete($id);
    public function courierBranchShow($id);
}
