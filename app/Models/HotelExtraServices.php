<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelExtraServices extends Model
{
    use HasFactory;
    protected $table = 'hotel_extra_services';
    
    protected $fillable = [
        'hotel_id','hotel_id', 	'es_name', 	'es_price',	'es_max_qty', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];
}
