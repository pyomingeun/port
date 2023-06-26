<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomBeds extends Model
{
    use HasFactory;
    protected $table = 'room_beds';
    
    protected $fillable = [
        'hotel_id','room_id','bed_type', 'bed_qty', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];
    
}
