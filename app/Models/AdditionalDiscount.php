<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalDiscount extends Model
{
    use HasFactory;
    protected $table = 'additional_discounts';
    
    protected $fillable = [
        'booking_id', 'amount', 'amount_type', 'reason','effective_amount', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];
}
