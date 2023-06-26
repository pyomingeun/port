<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelBankAcDetails extends Model
{
    use HasFactory;
    
    protected $table = 'bank_ac_details';
    
    protected $fillable = [
        'hotel_id', 'account_num', 	'bank_name',  'ac_holder_name', 'created_by', 'updated_by', 'created_at', 'updated_at'  
    ];
}
