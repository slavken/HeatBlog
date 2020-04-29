<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;

    function users()
    {
        return $this->belongsToMany('App\User');
    }

    function permissions()
    {
        return $this->belongsToMany('App\Permission');
    }
}
