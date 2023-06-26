<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelFeatures extends Model
{
    use HasFactory;
    protected $table = 'hotel_features';
    
    protected $fillable = [
        'hotel_id','features_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];
}
