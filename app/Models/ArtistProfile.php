<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistProfile extends Model
{
    use HasFactory;

    // Define the attributes that are mass assignable
    protected $fillable = [
        'user_id',
        'username',
        'hometown',
        'profile_picture',
        'bio',
        'total_sales',
        'average_rating',
    ];

    /**
     * The user that owns the artist profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the products associated with the artist.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Calculate the total sales for the artist (can be done dynamically based on orders)
     */
    public function getTotalSalesAttribute()
    {
        // Total sales can be calculated dynamically by counting the associated products
        return $this->products()->count();
    }

    /**
     * Calculate the average rating for the artist.
     * Assuming products have a 'rating' field.
     */
    public function getAverageRatingAttribute()
    {
        // Return the average rating of products for this artist
        $average = $this->products()->avg('rating');
        return $average ? number_format($average, 1) : 'No ratings yet';
    }
}
