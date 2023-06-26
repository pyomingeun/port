<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomImages extends Model
{
    use HasFactory;
    protected $table = 'room_images';
    
    protected $fillable = [
        'hotel_id','room_id','room_image', 'is_featured', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];
}
