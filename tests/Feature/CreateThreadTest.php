<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guest_cannot_create_thread()
    {
//        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->withExceptionHandling()
            ->post('/threads')
            ->assertRedirect('login');
    }

    /** @test */
    public function guest_cannot_access_create_thread_page()
    {
        $this->withExceptionHandling()
            ->get('/threads/create')
            ->assertRedirect('login');
    }

    /** @test */
    public function an_authorized_user_can_create_thread()
    {
        $this->signIn();

        $thread = make('App\Thread');

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function a_thread_requires_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_channel_id()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 345])
            ->assertSessionHasErrors('channel_id');

    }


    /**
     * Helper function for creating thread
     * @param array $attributes
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function publishThread($attributes = [])
    {
        $this->withExceptionHandling()
            ->signIn();

        $thread = make('App\Thread', $attributes);

        return $this->post('/threads', $thread->toArray());
    }
}
