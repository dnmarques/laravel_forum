<?php

namespace App\Repositories;

use App\User;
use App\Topic;
use App\Message;
use Illuminate\Support\Facades\Cache;

class MessagesRepository {

	public function updateContent($message_id, $topic_id, $content) {
		$tags = ['topic-'.$topic_id.'-messages'];
		$return = Message::where([['id', $message_id],['topic_id', $topic_id]])->update(['content' => $content]);
		Cache::tags('topic-'.$topic_id.'-messages')->flush();
		return $return;

	}

	public function getMessageFromTopic($topic_id, $message_id) {
		$return = Message::where([['topic_id', '=', $topic_id],['id', '=', $message_id]])->pluck('content');
		return $return[0];
	}

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
		
		$tags = ['topic-' . $message->topic_id . '-messages'];
		Cache::tags($tags)->flush();
	}

	public function destroy(Message $message) {
		// $key = 'topic-'. $message->topic_id . '-message-' . $message->id;
		$tags = ['topic-' . $message->topic_id . '-messages'];
		// Cache::forget($key); usar so se houver operacao de aceder apenas a 1 mensagem
		Cache::tags($tags)->flush();
		return $message->delete();
	}
}