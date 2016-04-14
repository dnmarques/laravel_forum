<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;
use App\User;
use App\Topic;
use App\Message;

class TopicsRepository {

	public function getTopicTitle($topic_id) {
		$key 	 = 'topic-'.$topic_id.'-title';
		$tags[0] = 'topics';

		return Cache::tags($tags)->remember($key, 2, function() use($topic_id) {
			$array = Topic::where('id', '=', $topic_id)->pluck('title');
			return $array[0];
		});
		/*\Debugbar::addMessage('A verificar cache...', 'TopicsRepository');
		return Cache::tags($tags)->remember($key, 2, function() use($key, $topic_id, $tags) {
			$array = Topic::where('id', '=', $topic_id)->pluck('title');
			\Debugbar::addMessage('MISS - Colocado na cache key: '. $key 
				. ' tags: ' . implode(", ", $tags), 'TopicsRepository');
			return $array[0];
		});*/
	}

	public function allWithUser() {
		$key 	 = 'topics-list';
		$tags = ['users', 'topics'];

		\Debugbar::addMessage('A verificar cache...', 'TopicsRepository');
		return Cache::tags($tags)->remember($key, 2, function() use($key, $tags) {
			$result = Topic::select('title', 'name', 'topics.id', 'topics.user_id')->
					join('users', 'users.id', '=', 'topics.user_id')->get();
			\Debugbar::addMessage('MISS - Colocado na cache key: '. $key 
				. ' tags: ' . implode(", ", $tags), 'TopicsRepository');
			return $result;
		});
	}

	public function getAllMessagesFromTopic($topic_id) {
		$key 	 = 'topic-'.$topic_id.'-messages';
		$tags = ['messages', 'topics'];

		return Cache::tags($tags)->remember($key, 2, function() use ($topic_id) {
			return Topic::select('messages.*', 'users.name')
						->where('topics.id', '=', $topic_id)
						->join('messages', 'messages.topic_id', '=', 'topics.id')
						->join('users', 'users.id', '=', 'messages.user_id')
						->get();
		});
		/*\Debugbar::addMessage('A verificar cache...', 'TopicsRepository');
		return Cache::tags($tags)->remember($key, 2, function() use ($topic_id, $key, $tags) {
			$result = Topic::select('messages.*', 'users.name')
						->where('topics.id', '=', $topic_id)
						->join('messages', 'messages.topic_id', '=', 'topics.id')
						->join('users', 'users.id', '=', 'messages.user_id')
						->get();
			\Debugbar::addMessage('MISS - Colocado na cache key: '. $key 
				. ' tags: ' . implode(", ", $tags), 'TopicsRepository');
			return $result;
		});*/
	}

	public function create(User $user, $title) {
		$topic = $user->topics()->create([
				'title' => $title,
			]);
		$tags[0] = 'topics';
		Cache::tags($tags)->flush();
		\Debugbar::addMessage('Flush das tags: ' . implode(", ", $tags), 'TopicsRepository');
		return $topic;
	}

	public function destroy(Topic $topic) {
		Message::where('topic_id', '=', $topic->id)->delete();
		$topic->delete();
		$tags = ['messages', 'topics'];
		Cache::tags($tags)->flush();
		\Debugbar::addMessage('Flush das tags: ' . implode(", ", $tags), 'TopicsRepository');
	}

	public function lastMessageId(Topic $topic) {
		return Topic::select('max(id)')->from('messages')->where('topic_id', '=', $topic->id);
	}
}