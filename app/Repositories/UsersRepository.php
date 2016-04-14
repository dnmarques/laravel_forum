<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\Cache;

class UsersRepository {

	public function changeName($user_id, $new_name) {
		$return = User::Where('id', $user_id)
						->update(['name' => $new_name]);
		$tags[0] = 'user-'.$user_id;
		$tags[1] = 'topics-list'; // pode ser evitado
		Cache::tags($tags)->flush();
		\Debugbar::addMessage('Flush das tags: ' . implode(", ", $tags), 'UsersRepository');
		return $return;
	}
}