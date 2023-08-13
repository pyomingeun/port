<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facilities extends Model
{
    use HasFactory;
    protected $table = 'facilities';
    
    protected $fillable = [
        'facility_name', 'facility_icon'  
    ];

    public function hasHotels()
    {
        return $this->hasMany(HotelFacilities::class, "facilities_id",  "id"); 
    }
}
