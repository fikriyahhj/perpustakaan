<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'transaction_number',
        'customer',
        'subtotal',
        'discount',
        'tax',
        'other_fee',
        'grand_total',
        'payment',
        'change',
        'payment_method',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}