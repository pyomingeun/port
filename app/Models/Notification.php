<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    
    protected $fillable = [
        'booking_id', 'user_id', 'message', 'read', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];
}
