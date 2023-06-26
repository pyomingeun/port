<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;
    protected $table = 'reward_history';
    
    protected $fillable = [
        'slug', 'user_id', 'booking_slug', 'title', 'message', 'reward_points', 'remaing_points', 'reward_type', 'transaction_on', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];
}
