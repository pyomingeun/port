<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminGlobalVariable extends Model
{
    use HasFactory;
    protected $table = 'admin_global_variables';
    
    protected $fillable = [
        'type','value_for','value','value_type', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];
}
