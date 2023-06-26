<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelFacilities extends Model
{
    use HasFactory;
    protected $table = 'hotel_facilities';
    
    protected $fillable = [
        'hotel_id','facilities_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];
}
