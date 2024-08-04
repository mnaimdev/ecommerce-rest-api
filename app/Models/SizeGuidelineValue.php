<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SizeGuidelineValue extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function sizeGuideline()
    {
        return $this->belongsTo(SizeGuideline::class);
    }

    public function sizeGuidelineLabel()
    {
        return $this->belongsTo(SizeGuidelineLabel::class);
    }
}
