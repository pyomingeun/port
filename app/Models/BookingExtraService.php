<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingExtraService extends Model
{
    use HasFactory;

    protected $table = 'booking_extra_services';
    
    protected $fillable = [
        'booking_id', 'es_id', 'price', 'qty', 'es_row_total', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];
}
