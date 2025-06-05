<?php

// app/Models/Cart.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // If you want to make sure the model is mass assignable, define $fillable
    protected $fillable = ['user_id'];

    // Define the relationship between Cart and CartItem
    public function items()
    {
        // A cart can have many items (CartItem model)
        return $this->hasMany(CartItem::class);
    }

    // Define the relationship between Cart and User
    public function user()
    {
        // A cart belongs to a user
        return $this->belongsTo(User::class);
    }
}

