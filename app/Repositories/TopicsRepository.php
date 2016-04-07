<?php

namespace App\Repositories;

use App\User;
use App\Topic;

class TopicsRepository {

	public function allWithUser() {
		return Topic::select('title', 'name', 'topics.id', 'topics.user_id')->
						join('users', 'users.id', '=', 'topics.user_id')->get();
	}

	public function getAllMessagesFromTopic(Topic $topic) {
		return Topic::select('messages.id', 'messages.content', 'messages.created_at', 'name')
						->where('topics.id', '=', $topic->id)
						->join('messages', 'messages.topic_id', '=', 'topics.id')
						->join('users', 'users.id', '=', 'messages.user_id')
						->get();
	}

	public function create(User $user, $title) {
		return $user->topics()->create([
				'title' => $title,
			]);
	}

	public function destroy(Topic $topic) {
		$topic->delete();
	}

	public function lastMessageId(Topic $topic) {
		return Topic::select('max(id)')->from('messages')->where('topic_id', '=', $topic->id);
	}
}