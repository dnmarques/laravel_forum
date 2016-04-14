<?php

namespace App\Repositories;

use App\User;

class UsersRepository {

	public function changeName($user_id, $new_name) {
		$user = User::find($user_id);
		$return = $user->update(['name' => $new_name]);
		return $return;
	}
}