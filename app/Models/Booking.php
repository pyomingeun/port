<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'bookings';
    
    protected $fillable = [
        'slug', 'hotel_id', 'room_id', 'customer_id', 'is_rated', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at','check_in_date', 'check_out_date', 'customer_full_name', 'customer_phone', 'customer_email', 'no_of_adults', 'no_of_childs', 'no_of_extra_guest', 'no_of_nights', 'child_ages', 'customer_notes', 'host_notes',   'per_night_charges', 'extra_guest_charges', 'long_stay_discount_amount', 'coupon_code', 'coupon_discount_amount', 'reward_points_used', 'payment_by_currency', 'payment_by_points',  'booking_status', 'payment_status', 'payment_method','extra_services_charges','sub_total','total_price','cancellation_policy','cancelled_by','cancelled_at','confirmed_by','confirmed_at','is_points_sent','additional_discount','childs_below_nyear','childs_plus_nyear','is_payout_generated','peakseason_price','weekend_price','weekday_price','no_of_weekdays','no_of_weekenddays','no_of_peakseason_days'
    ];
}
