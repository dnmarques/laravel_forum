<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Topic;

class TopicPolicy
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

    // Apenas o user dono do topico o pode apagar
    public function destroy(User $user, Topic $topic) {
        return $user->id === $topic->user_id;
    }
}
