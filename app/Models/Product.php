<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use App\Models\OrderItem;


class Product extends Model
{
    use HasFactory;

    // Define the attributes that are mass assignable
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'image',
    ];

    /**
     * Get the user who owns the product.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the artist profile associated with the product.
     */
    public function artistProfile()
    {
        return $this->belongsTo(ArtistProfile::class, 'user_id', 'user_id');
    }


public function reviews()
{
    return $this->hasMany(Review::class);
}

public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}

}
