<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    /**
     * @test
     */
    public function a_user_can_browse_threads()
    {

        $this->get('/threads')
            ->assertSee($this->thread->title);

    }

    /**
     * @test
     */
    function a_user_can_view_a_thread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    /**
     * @test
     */
    function a_reply_associated_with_a_thread()
    {

        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_thread_by_channel()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNoInChannel = create('App\Thread');

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNoInChannel->title);
    }

}
