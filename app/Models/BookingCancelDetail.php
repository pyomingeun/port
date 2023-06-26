<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingCancelDetail extends Model
{
    use HasFactory;

    protected $table = 'booking_cancel_details';
    
    protected $fillable = [
        'booking_id', 'refund_amount_in_points', 'refund_amount_in_money', 'total_refund_amount','cancellation_before_n_days','refund_percentage', 'refund_points', 'bank_name', 'iban_code', 'account_number','account_holder_name','cancellation_reason', 'refund_status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];
}
