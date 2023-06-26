<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Features extends Model
{
    use HasFactory;
    protected $table = 'features';
    
    protected $fillable = [
        'features_name','features_icon', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];

    public function hasHotels()
    {
        return $this->hasMany(HotelFeatures::class, "features_id",  "id")->where('status','active'); 
    }
}
