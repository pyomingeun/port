<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancellationCharges extends Model
{
    use HasFactory;

    protected $table = 'cancellation_charges';
    
    protected $fillable = [
        'hotel_id','same_day_refund', 'b4_1day_refund', 'b4_2days_refund', 'b4_3days_refund', 'b4_4days_refund', 'b4_5days_refund', 'b4_6days_refund', 'b4_7days_refund', 'b4_8days_refund', 'b4_9days_refund', 'b4_10days_refund', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];
}
