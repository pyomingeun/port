<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\RoomBeds;
use App\Models\RoomFacilities;
use App\Models\RoomFeatures;
use App\Models\RoomImages;

class Rooms extends Model
{
    use HasFactory;
    protected $table = 'rooms';
    
    protected $fillable = [
        'hotel_id','slug','no_of_bathrooms','room_name', 'room_size', 'room_featured_img', 'room_description', 'standard_occupancy','maximum_occupancy', 'freechild_occupancy', 'standard_price_weekday','standard_price_weekend', 'standard_price_peakseason', 'extra_guest_fee', 'basic_info_status', 'beds_status',	'roomfnf_status', 'pricing_status', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'
    ];

    public function hasImages()    {   return $this->hasMany(RoomImages::class, "room_id",  "id")->where('status','!=','deleted')->orderBy('room_images.is_featured', 'desc');    }

    public function hasBeds()    {   return $this->hasMany(RoomBeds::class, "room_id",  "id")->orderBy('room_beds.id', 'desc');    }

    public function hasImagesActive()    {   return $this->hasMany(RoomImages::class, "room_id",  "id")->where('status','=','active')->orderBy('room_images.is_featured', 'desc');    }

    public function hasBedsActive()    {   return $this->hasMany(RoomBeds::class, "room_id",  "id")->orderBy('room_beds.id', 'desc');    }
    
}
