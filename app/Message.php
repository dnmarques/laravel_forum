<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
	protected $fillable = ['content', 'topic_id', 'id', 'user_id'];
    
    public function topic() {
    	return $this->belongsTo('App\Topic');
    }
}
