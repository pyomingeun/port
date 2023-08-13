<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NearestTouristAttractions extends Model
{
    use HasFactory;

    protected $table = 'nearest_tourist_attractions';
    
    protected $fillable = [
        'hotel_id','attractions_name', 'nta_address', 'nta_latitude', 'nta_longitude', 'nta_description'  
    ];

}
