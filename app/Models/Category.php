<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function category()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->with('category');
    }


    // pivot
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class);
    }
}
