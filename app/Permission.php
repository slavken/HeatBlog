<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $timestamps = false;

    function roles()
    {
        return $this->belongsToMany('App\Role');
    }
}
