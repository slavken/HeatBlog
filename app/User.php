<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function posts()
    {
        return $this->hasMany('App\Post');
    }

    function comments()
    {
        return $this->hasMany('App\Comment');
    }

    function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    function isAdmin() {
        return $this->roles()->where('name', 'admin')->exists();
    }

    function permission($permission)
    {
        foreach ($this->roles as $role) {
            if ($role->permissions->pluck('name')->contains($permission)) {
                return true;
            }
        }
    }
}
