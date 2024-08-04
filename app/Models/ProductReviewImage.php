<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReviewImage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function productReview()
    {
        return $this->belongsTo(ProductReview::class);
    }
}
