<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\Cache;

class UsersRepository {

	public function changeName($user_id, $new_name) {
		$return = User::Where('id', $user_id)
						->update(['name' => $new_name]);
		// Quando se muda o nome de um user, podem existir topicos ou mensagens com informacoes desse user
		$tags[0] = 'users';
		$tags[1] = 'topics';
		$tags[2] = 'messages';

		Cache::tags($tags)->flush();
		\Debugbar::addMessage('Flush das tags: ' . implode(", ", $tags), 'UsersRepository');
		return $return;
	}
}