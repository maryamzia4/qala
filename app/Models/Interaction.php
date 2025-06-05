<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    use HasFactory;
    protected $table = 'interactions'; // Ensure it matches your database table name
    protected $fillable = ['user_id', 'product_id', 'interaction'];

}
