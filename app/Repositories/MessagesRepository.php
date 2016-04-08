<?php

namespace App\Repositories;

use App\User;
use App\Topic;
use App\Message;
use Illuminate\Support\Facades\Cache;

class MessagesRepository {

	public function storeMessage(User $user, Topic $topic, $content) {
		$counter = Topic::from('messages')->where('topic_id', '=', $topic->id)->max('id');

		if($counter == null)
			$counter = 0;
		$counter++;

		$message = $topic->messages()->create([
				'id' => $counter,
				'topic_id' => $topic->id,
				'content' => $content,
				'user_id' => $user->id
			]);
		
		$key = 'topic-'. $message->topic_id . '-message-' . $message->id;
		Cache::tags(['topic-' . $message->topic_id])->put($key, $message, 10);
	}

	public function destroy(Message $message) {
		$key = 'topic-'. $message->topic_id . '-message-' . $message->id;
		Cache::forget($key);
		return $message->delete();
	}
}