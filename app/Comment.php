<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use UuidsTrait;

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'author','comment','created_at','post_id'
    ];
    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
