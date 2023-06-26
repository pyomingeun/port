<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyFavorite extends Model
{
    use HasFactory;
    protected $table = 'my_favorites';
    
    protected $fillable = [
        'hotel_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];
}
