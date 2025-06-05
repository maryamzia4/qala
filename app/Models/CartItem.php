<?php


// app/Models/CartItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    // Define the fillable attributes for CartItem
    protected $fillable = ['cart_id', 'product_id', 'quantity', 'price'];

    // Define the relationship between CartItem and Cart
    public function cart()
    {
        // A cart item belongs to a cart
        return $this->belongsTo(Cart::class);
    }

    // Define the relationship between CartItem and Product
    public function product()
    {
        // A cart item belongs to a product
        return $this->belongsTo(Product::class);
    }
}
