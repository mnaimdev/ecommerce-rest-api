<?php

namespace App\Contracts\Dashboard;

interface AttributeNameInterface
{
    public function attributeName();
    public function attributeNameStore($request);
    public function attributeNameUpdate($request, $id);
    public function attributeNameDelete($id);
    public function attributeNameShow($id);
}
