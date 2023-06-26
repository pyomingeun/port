<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsLetter extends Model
{
    use HasFactory;

    protected $table = 'news_letter';
    
    protected $fillable = [
        'user_id', 'email', 'is_subscribed', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];

}
