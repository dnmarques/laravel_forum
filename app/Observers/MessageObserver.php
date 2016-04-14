<?php

namespace App\Observers;

use App\Message;
use Illuminate\Support\Facades\Cache;

class MessageObserver {

	public function created(Message $message) {
		$tags = ['messages'];
		Cache::tags($tags)->flush();
		\Debugbar::addMessage('Flush das tags: ' . implode(", ", $tags), 'MessagesRepository');
	}

	public function updated(Message $message) {
		$tags[0] = 'messages';
		Cache::tags($tags)->flush();
		\Debugbar::addMessage('Flush das tags: ' . implode(", ", $tags), 'MessagesRepository');
	}

	public function deleted(Message $message) {
		$tags[0] = 'messages';

		Cache::tags($tags)->flush();
		\Debugbar::addMessage('Flush das tags: ' . implode(", ", $tags), 'MessagesRepository');
	}
}