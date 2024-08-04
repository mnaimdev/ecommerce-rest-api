<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewReplyImage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function reviewReply()
    {
        return $this->belongsTo(ReviewReply::class);
    }
}
