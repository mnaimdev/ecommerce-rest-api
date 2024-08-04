<?php

namespace App\Models;

use App\Enums\ProductStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // protected $casts = [
    //     'status' => ProductStatusEnum::class
    // ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function taxSetting()
    {
        return $this->belongsTo(TaxSetting::class);
    }

    public function flashSale()
    {
        return $this->belongsTo(FlashSale::class);
    }

    // pivot
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function faqs()
    {
        return $this->belongsToMany(Faq::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class);
    }

    public function productRatings()
    {
        return $this->hasMany(ProductRating::class);
    }
}
