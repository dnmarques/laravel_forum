<?php

namespace App\Observers;

use App\Topic;
use Illuminate\Support\Facades\Cache;

class TopicObserver {

	public function created(Topic $topic) {
		$tags[0] = 'topics';
		Cache::tags($tags)->flush();
		\Debugbar::addMessage('Flush das tags: ' . implode(", ", $tags), 'TopicsRepository');
	}

	// TODO not working
	public function deleting(Topic $topic) {
		dd("fired");
		$tags = ['messages', 'topics'];
		Cache::tags($tags)->flush();
		\Debugbar::addMessage('Flush das tags: ' . implode(", ", $tags), 'TopicsRepository');
	}
}