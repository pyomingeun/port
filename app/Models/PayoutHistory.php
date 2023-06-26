<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayoutHistory extends Model
{
    use HasFactory;
    protected $table = 'payout_history';
    
    protected $fillable = [
        'hotel_id', 'payout_id', 'booking_id', 'commission_rate', 'commission', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];
    
}
