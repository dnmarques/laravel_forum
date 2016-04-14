<?php

namespace App;

use App\Observers\MessageObserver;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
	protected $fillable = ['content', 'topic_id', 'id', 'user_id'];
    public $incrementing = false;
    
    public static function boot() {
    	Message::observe(new MessageObserver);
    }

    public function topic() {
    	return $this->belongsTo('App\Topic');
    }
}
