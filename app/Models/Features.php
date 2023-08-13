<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Features extends Model
{
    use HasFactory;
    protected $table = 'features';
    
    protected $fillable = [
        'feature_name','feature_icon' 
    ];

    public function hasHotels()
    {
        return $this->hasMany(HotelFeatures::class, "features_id",  "id"); 
    }
}
