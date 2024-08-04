<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryChargeSetting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function deliveryRules()
    {
        return $this->hasMany(DeliveryRule::class);
    }
}
