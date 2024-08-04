<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function paymentInformations()
    {
        return $this->hasMany(PaymentInformation::class);
    }
}
