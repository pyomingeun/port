<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\HotelInfo;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name','email','phone','profile_pic','profile_setup_step','hotel_id','password','access','created_at','updated_at', 'hotel_id','forgot_password_code','social_id','signup_by','status','set_password_code','created_by','updated_by','change_email_verification_code',' new_email_for_change','total_rewards_points','is_loging','last_activity_at', 'agree_required', 'agree_forever', 'agree_message'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasHotelInfo()    {   return $this->hasOne(HotelInfo::class, "hotel_id",  "hotel_id");    }
}
