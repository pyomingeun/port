<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupons';
    
    protected $fillable = [
        'slug', 'hotel_id', 'coupon_code_name', 'discount_type', 'discount_amount', 'max_discount_amount', 'expiry_date', 'limit_per_user', 'available_no_of_coupon_to_use', 'no_of_coupon_used', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];

}
