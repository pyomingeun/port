<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelPeakSeason extends Model
{
    use HasFactory;
    protected $table = 'hotel_peak_season';
    
    protected $fillable = [
        'hotel_id','season_name','start_date','end_date', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];
}
