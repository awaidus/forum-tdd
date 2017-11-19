<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_unauthenticated_user_may_not_add_replies()
    {
        $this->withExceptionHandling()
            ->post('/threads/slug/1/replies', [])
            ->assertRedirect('login');
    }

    /**
     * @test
     */
    public function a_authenticated_user_may_participate_in_forum_thread()
    {
        $this->be($user = factory('App\User')->create());

        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->make();

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }


}