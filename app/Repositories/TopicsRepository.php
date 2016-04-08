<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;
use App\User;
use App\Topic;
use App\Message;

class TopicsRepository {

	public function getTopicTitle($topic_id) {
		$key = 'topic-'.$topic_id.'-title';
		$tags = 'topic-'.$topic_id;
		return Cache::tags($tags)->remember($key, 2, function() use($topic_id) {
			$array = Topic::where('id', '=', $topic_id)->pluck('title');
			return $array[0];
		});
	}

	public function allWithUser() {
		
		return Cache::remember('topics-list', 2, function() {
			return Topic::select('title', 'name', 'topics.id', 'topics.user_id')->
					join('users', 'users.id', '=', 'topics.user_id')->get();
		});
	}

	public function getAllMessagesFromTopic($topic_id) {
		$tags = ['topic-' . $topic_id . '-messages'];
		$key = 'topic-'. $topic_id. '-messages';

		return Cache::tags($tags)->remember($key, 2, function() use ($topic_id) {
			return Topic::select('messages.*', 'users.name')
						->where('topics.id', '=', $topic_id)
						->join('messages', 'messages.topic_id', '=', 'topics.id')
						->join('users', 'users.id', '=', 'messages.user_id')
						->get();
		});
	}

	public function create(User $user, $title) {
		$topic = $user->topics()->create([
				'title' => $title,
			]);
		Cache::forget('topics-list');
		return $topic;
	}

	public function destroy(Topic $topic) {
		Message::where('topic_id', '=', $topic->id)->delete();
		$topic->delete();
		Cache::forget('topics-list');
		Cache::tags('topic-'.$topic->id)->flush();
	}

	public function lastMessageId(Topic $topic) {
		return Topic::select('max(id)')->from('messages')->where('topic_id', '=', $topic->id);
	}
}