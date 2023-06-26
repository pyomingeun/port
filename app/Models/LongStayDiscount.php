<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LongStayDiscount extends Model
{
    use HasFactory;
    protected $table = 'long_stay_discount';
    
    protected $fillable = [
        'hotel_id','lsd_min_days','lsd_max_days','lsd_discount_amount','lsd_discount_type', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];
}
