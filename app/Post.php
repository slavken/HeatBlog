<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    function comments()
    {
        return $this->hasMany('App\Comment');
    }

    function user()
    {
        return $this->belongsTo('App\User');
    }
}
