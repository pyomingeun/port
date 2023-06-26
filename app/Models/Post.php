<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'title_korean', 'slug', 'content', 'content_korean', 'image', 'image_alt', 'status', 'type'
    ];


    public function hasImages()
    {
        return $this->hasMany(PostImage::class, "post_id",  "id")->where('status','active');
    }

}
