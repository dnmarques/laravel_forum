<?php

namespace App\Repositories;

use App\User;
use App\Topic;
use App\Message;
use Illuminate\Support\Facades\Cache;

class MessagesRepository {

	public function updateContent($message_id, $topic_id, $content) { // DONE
		$tags[0] = 'topic-'.$topic_id.'-message-'.$message_id.'-content';
		$tags[1] = 'topic-'.$topic_id.'-message-'.$message_id;
		$tags[2] = 'topic-'.$topic_id.'-messages';
		$return = Message::where([['id', $message_id],['topic_id', $topic_id]])->update(['content' => $content]);
		Cache::tags($tags)->flush();
		\Debugbar::addMessage('Flush das tags: ' . implode(", ", $tags), 'MessagesRepository');
		return $return;

	}

	public function getMessageFromTopic($topic_id, $message_id) { // DONE
		$key 	 = 'topic-'.$topic_id.'-message-'.$message_id.'-content';
		$tags[0] = 'topic-'.$topic_id.'-message-'.$message_id.'-content';
		$tags[1] = 'topic-'.$topic_id.'-message-'.$message_id;
		$tags[2] = 'topic-'.$topic_id.'-messages';
		$tags[3] = 'topic-'.$topic_id;
		/*$return = Cache::tags($tags)->remember($key, 2, function() use($topic_id, $message_id) {
			return Message::where([['topic_id', '=', $topic_id],['id', '=', $message_id]])->pluck('content');
		});*/
		\Debugbar::addMessage('A verificar cache...', 'MessagesRepository');
		$result = Cache::tags($tags)->remember($key, 2, function() use($topic_id, $message_id, $key, $tags) {
			$result = Message::where([['topic_id', '=', $topic_id],['id', '=', $message_id]])->pluck('content');
			\Debugbar::addMessage('MISS - Colocado na cache key: '. $key 
				. ' tags: ' . implode(", ", $tags), 'MessagesRepository');
			return $result;
		});
		return $result[0];
	}

	public function storeMessage(User $user, $topic_id, $content) { // DONE
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
		
		$tags = ['topic-'.$message->topic_id.'-messages'];
		Cache::tags($tags)->flush();
		\Debugbar::addMessage('Flush das tags: ' . implode(", ", $tags), 'MessagesRepository');
	}

	public function destroy(Message $message) { // DONE
		$tags[0] = 'topic-'.$message->topic_id.'-message-' . $message->id;
		$tags[1] = 'topic-'.$message->topic_id.'-messages';
		Cache::tags($tags)->flush();
		\Debugbar::addMessage('Flush das tags: ' . implode(", ", $tags), 'MessagesRepository');
		Message::where([['topic_id', $message->topic_id], ['id', $message->id]])->delete();

	}

	private function getCounter($topic_id) {
		return Message::where('topic_id', $topic_id)->max('id');
	}
}