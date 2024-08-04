<?php

namespace App\Contracts\Dashboard;

interface ProductRatingInterface
{
    public function productRating();
    public function productRatingStore($request);
    public function productRatingUpdate($request, $id);
    public function productRatingDelete($id);
    public function productRatingShow($id);
    public function productRatingStatusUpdate($request);
}
