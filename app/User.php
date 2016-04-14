<?php

namespace App;

use App\Observers\UserObserver;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
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

    public static function boot() {
        User::observe(new UserObserver);
    }

    public function topics() {
        return $this->hasMany('App\Topic');
    }

    public function messages() {
        return $this->hasMany('App\Message');
    }
}
