<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    use HasFactory;
    protected $table = 'notification_settings';
    
    protected $fillable = [
        'user_id', 'booking_on_hold_email', 'booking_confirmed_email', 'booking_completed_email', 'booking_cancelled_email', 'booking_refund_email', 'booking_on_hold_sms', 'booking_confirmed_sms', 'booking_completed_sms', 'booking_cancelled_sms', 'booking_refund_sms', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];
}
