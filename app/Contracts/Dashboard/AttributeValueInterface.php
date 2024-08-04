<?php

namespace App\Contracts\Dashboard;

interface AttributeValueInterface
{
    public function attributeValue();
    public function attributeValueStore($request);
    public function attributeValueUpdate($request, $id);
    public function attributeValueDelete($id);
    public function attributeValueShow($id);
}
