<?php

namespace App\Policies;

use App\Thread;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the odel=Thread.
     *
     * @param  \App\User  $user
     * @param  \App\Thread $thread
     * @return mixed
     */
    public function view(User $user, Thread $thread)
    {
        //
    }

    /**
     * Determine whether the user can create odel=Threads.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the odel=Thread.
     *
     * @param  \App\User  $user
     * @param  \App\Thread $thread
     * @return mixed
     */
    public function update(User $user, Thread $thread)
    {
        return $thread->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the odel=Thread.
     *
     * @param  \App\User  $user
     * @param  \App\Thread $thread
     * @return mixed
     */
    public function delete(User $user, Thread $thread)
    {
        //
    }
}
