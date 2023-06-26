<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facilities extends Model
{
    use HasFactory;
    protected $table = 'facilities';
    
    protected $fillable = [
        'facilities_name', 'facilities_icon', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];

    public function hasHotels()
    {
        return $this->hasMany(HotelFacilities::class, "facilities_id",  "id")->where('status','active'); 
    }
}
