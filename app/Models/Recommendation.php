<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'score', // optional
    ];

    /**
     * Relationship: A recommendation belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: A recommendation is for a product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
