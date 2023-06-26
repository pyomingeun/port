<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    use HasFactory;
    protected $table = 'payouts';
    
    protected $fillable = [
        'hotel_id','slug', 'sales_period_start', 'sales_period_end', 'settlement_date', 'sales_amount', 'payble_amount', 'no_of_bookings', 'pay_status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];
}
