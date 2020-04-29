<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    function posts()
    {
        return $this->belongsToMany('App\Post');
    }
}
