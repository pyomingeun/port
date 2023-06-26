<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomFacilities extends Model
{
    use HasFactory;
    protected $table = 'room_facilities';
    
    protected $fillable = [
        'hotel_id','room_id','facilities_id','hotel_facilities_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];
}
