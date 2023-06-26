<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingReview extends Model
{
    use HasFactory;
    protected $table = 'rating_reviews';
    
    protected $fillable = [
        'hotel_id', 'booking_id','cleanliness','facilities','service','value_for_money','avg_rating','review', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];
}
