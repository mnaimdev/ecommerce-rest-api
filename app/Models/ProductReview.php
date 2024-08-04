<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productReviewImages()
    {
        return $this->hasMany(ProductReviewImage::class);
    }

    public function productReviewReplies()
    {
        return $this->hasMany(ReviewReply::class);
    }
}
