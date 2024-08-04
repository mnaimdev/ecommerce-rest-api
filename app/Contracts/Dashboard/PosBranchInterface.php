<?php

namespace App\Contracts\Dashboard;

interface PosBranchInterface
{
    public function posBranch();
    public function posBranchStore($request);
    public function posBranchUpdate($request, $id);
    public function posBranchDelete($id);
    public function posBranchShow($id);
}
