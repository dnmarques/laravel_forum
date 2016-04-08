<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;
use App\User;
use App\Topic;
use App\Message;

class TopicsRepository {

	public function allWithUser() {

		return Cache::remember('topics-list', 2, function() {
			return Topic::select('title', 'name', 'topics.id', 'topics.user_id')->
					join('users', 'users.id', '=', 'topics.user_id')->get();
		});
	}

	public function getAllMessagesFromTopic(Topic $topic) {
		return Topic::select('messages.*', 'users.name')
						->where('topics.id', '=', $topic->id)
						->join('messages', 'messages.topic_id', '=', 'topics.id')
						->join('users', 'users.id', '=', 'messages.user_id')
						->get();
	}

	public function create(User $user, $title) {
		$topic = $user->topics()->create([
				'title' => $title,
			]);
		Cache::forget('topics-list');
		//Cache::tags(['topic-' . $topic->id, 'topics-list'])->put('topic-'.$topic->id, $topic, 5);
		return $topic;
	}

	public function destroy(Topic $topic) {
		Message::where('topic_id', '=', $topic->id)->delete();
		$topic->delete();
		Cache::forget('topics-list');
		//Cache::tags(['topic-' . $topic->id])->flush();
	}

	public function lastMessageId(Topic $topic) {
		return Topic::select('max(id)')->from('messages')->where('topic_id', '=', $topic->id);
	}
}