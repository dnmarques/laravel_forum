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
		$key = 'topic-' . $topic_id . '-message-' . $message_id . '-content';
		$tags[0] = 'topic-'.$topic_id.'-message-'.$message_id.'-content';
		$tags[1] = 'topic-'.$topic_id.'-message-'.$message_id;
		$tags[2] = 'topic-'.$topic_id.'-messages';
		$return = Cache::tags($tags)->remember($key, 2, function() use($topic_id, $message_id) {
			return Message::where([['topic_id', '=', $topic_id],['id', '=', $message_id]])->pluck('content');
		});
		return $return[0];
	}

	public function storeMessage(User $user, $topic_id, $content) {
		$counter = $this->getCounter($topic_id);

		if($counter == null)
			$counter = 0;
		$counter++;

		$message = $user->messages()->create([
				'id' => $counter,
				'topic_id' => $topic_id,
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

	private function getCounter($topic_id) {
		return Message::where('topic_id', $topic_id)->max('id');
	}
}