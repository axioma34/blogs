<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Post extends Model
{
    use UuidsTrait;

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'title','short_text','text','created_at'
    ];
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
