<?php

namespace App;

use App\Observers\TopicObserver;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['title'];

    public static function boot() {
    	User::observe(new TopicObserver);
    }

    public function messages() {
    	return $this->hasMany('App\Message');
    }
}
