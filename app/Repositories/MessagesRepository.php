<?php

namespace App\Repositories;

use App\User;
use App\Topic;
use App\Message;
use Illuminate\Support\Facades\Cache;

class MessagesRepository {

	public function updateContent($message_id, $topic_id, $content) {
		$message = Message::where([['id', $message_id],['topic_id', $topic_id]])->first();
		$message->update(['content' => $content]);
		return $message;

	}

	public function getMessageFromTopic($topic_id, $message_id) {
		$key 	 = 'topic-'.$topic_id.'-message-'.$message_id.'-content';
		$tags[0] = 'messages';
		$result = Cache::tags($tags)->remember($key, 2, function() use($topic_id, $message_id) {
			return Message::where([['topic_id', '=', $topic_id],['id', '=', $message_id]])->pluck('content');
		});
		return $result[0];
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
	}

	public function destroy(Message $message) {
		$message = Message::where([['topic_id', $message->topic_id], ['id', $message->id]])->first();
		$message->delete();
	}

	private function getCounter($topic_id) {
		return Message::where('topic_id', $topic_id)->max('id');
	}
}