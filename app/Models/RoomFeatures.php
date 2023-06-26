<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomFeatures extends Model
{
    use HasFactory;

    protected $table = 'room_features';
    
    protected $fillable = [
        'hotel_id','room_id','features_id','hotel_features_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];
}
