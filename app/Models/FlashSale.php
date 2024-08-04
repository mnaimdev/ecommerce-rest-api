<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function flashSaleProduct()
    {
        return $this->hasMany(FlashSaleProduct::class);
    }
}
