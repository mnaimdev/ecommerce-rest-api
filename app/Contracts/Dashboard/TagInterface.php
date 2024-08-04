<?php

namespace App\Contracts\Dashboard;

interface TagInterface
{
    public function tag();
    public function tagStore($request);
    public function tagUpdate($request, $id);
    public function tagDelete($id);
    public function tagShow($id);
}
