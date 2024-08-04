<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewReply extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productReview()
    {
        return $this->belongsTo(ProductReview::class);
    }

    public function reviewReplyImage()
    {
        return $this->hasMany(ReviewReplyImage::class);
    }
}
