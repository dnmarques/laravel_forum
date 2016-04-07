<?php

namespace App\Repositories;

use App\User;
use App\Topic;

class MessagesRepository {

	public function storeMessage(User $user, Topic $topic, $content) {
		return $topic->messages()->create([
				'id' => Topic::from('messages')->where('topic_id', '=', $topic->id)->max('id') + 1,
				'content' => $content,
				'topic_id' => $topic->id,
				'user_id' => $user->id
			]);
	}
}