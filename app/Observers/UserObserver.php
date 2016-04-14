<?php

namespace App\Observers;

use App\User;
use Illuminate\Support\Facades\Cache;

class UserObserver {

	public function created(User $user) {
		$tags[0] = 'users';
		Cache::tags($tags)->flush();
		\Debugbar::addMessage('Flush das tags: ' . implode(", ", $tags), 'User criado');
	}

	public function updated(User $user) {
		// Quando se modifica um user, podem existir topicos ou mensagens com informacoes desse user
		$tags[0] = 'users';
		$tags[1] = 'topics';
		$tags[2] = 'messages';
		
		Cache::tags($tags)->flush();
		\Debugbar::addMessage('Flush das tags: ' . implode(", ", $tags), 'User modificado');
	}

	public function deleted(User $user) {
		$tags[0] = 'users';
		$tags[1] = 'topics';
		$tags[2] = 'messages';

		Cache::tags($tags)->flush();
		\Debugbar::addMessage('Flush das tags: ' . implode(", ", $tags), 'User eliminado');
	}
}