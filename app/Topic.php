<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['title'];

    public function messages() {
    	return $this->hasMany('App\Message');
    }
}
