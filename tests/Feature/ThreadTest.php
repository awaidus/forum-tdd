<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_user_can_browse_threads()
    {
        $thread = factory('App\Thread')->create();

        $this->get('/threads')
            ->assertSee($thread->title);

    }

    /**
     * @test
     */
    function a_user_can_view_a_thread()
    {
        $thread = factory('App\Thread')->create();

        $this->get('/threads/' . $thread->id)
            ->assertSee($thread->title);
    }


}
