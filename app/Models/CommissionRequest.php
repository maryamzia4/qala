<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommissionRequest extends Model
{
    use HasFactory;

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'artist_id',
        'customer_id',
        'name',
        'email',
        'title',
        'canvas_size',
        'description',
        'deadline',
        'budget',
        'delivery_type',
        'reference_images',
        'status',
        'payment_status',
    ];

    // Cast attributes to their respective data types
    protected $casts = [
        'reference_images' => 'array', // Convert JSON to array
        'deadline' => 'date', // Convert to date
    ];

    // Relationships
    public function artist()
    {
        return $this->belongsTo(User::class, 'artist_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    
}
