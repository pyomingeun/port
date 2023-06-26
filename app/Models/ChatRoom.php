<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'friend_id'
    ];

    public function getLastMessage() {
        return $this->hasOne(ChatMessage::class, 'chat_room_id', 'id')->latest();
    }

    public function getUser () {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getFriend () {
        return $this->hasOne(User::class, 'id', 'friend_id');
    }

}
