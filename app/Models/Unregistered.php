<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unregistered extends Model
{
    use HasFactory;
    
    protected $table = 'unregistered';
    
    protected $fillable = [
        'full_name','email','phone','password','activation_code','access','created_at','updated_at' 
    ];

}
