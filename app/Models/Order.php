<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'status',
    'total_price',
    'payment_intent_id',
    'name',
    'email',
    'phone',
    'address',
];


    // Relationship: An order belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: An order has many order items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
