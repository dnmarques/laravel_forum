<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\Cache;

class UsersRepository {

	public function changeName($user_id, $new_name) {
		return User::Where('id', $user_id)
						->update(['name' => $new_name]);
	}
}