<?php

namespace App\Policies;

use App\User;
use App\Message;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Only the message owner can destroy it
     * @param  User    $user    [description]
     * @param  Message $message [description]
     * @return [type]           [description]
     */
    public function destroy(User $user, Message $message) {
        return $user->id === $message->user_id;
    }
}
