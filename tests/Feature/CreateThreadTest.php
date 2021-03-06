<?php

namespace Tests\Feature;

use App\Activity;
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
            ->post(route('threads'))
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
    function authenticated_users_must_first_confirm_their_email_address_before_creating_threads()
    {
        $user = factory('App\User')
            ->states('unconfirmed')
            ->create();

        $this->signIn($user);

        $thread = make('App\Thread');

        $this->post(route('threads'), $thread->toArray())
            ->assertRedirect(route('threads'))
            ->assertSessionHas('flash', 'You must first confirm your email address.');
    }

    /** @test */
    public function a_user_can_create_new_forum_threads()
    {
        $this->signIn();

        $thread = make('App\Thread');

        $response = $this->post(route('threads'), $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function a_thread_requires_title()
    {
        $this->publishThread([ 'title' => null ])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_body()
    {
        $this->publishThread([ 'body' => null ])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_channel_id()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread([ 'channel_id' => null ])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread([ 'channel_id' => 345 ])
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

        return $this->post(route('threads'), $thread->toArray());
    }

    /** @test */
    function a_thread_requires_a_unique_slug()
    {
        $this->signIn();

        $thread = create('App\Thread', [ 'title' => 'Foo Title' ]);

        $this->assertEquals($thread->slug, 'foo-title');

        $thread = $this->postJson(route('threads'), $thread->toArray())->json();
        $this->assertEquals("foo-title-{$thread['id']}", $thread['slug']);

    }

    /** @test */
    function a_thread_with_a_title_that_ends_in_a_number_should_generate_the_proper_slug()
    {
        $this->signIn();

        $thread = create('App\Thread', [ 'title' => 'Some Title 24' ]);

        $thread = $this->postJson(route('threads'), $thread->toArray())->json();

        $this->assertEquals("some-title-24-{$thread['id']}", $thread['slug']);
    }

    /** @test */
    function unauthorized_users_may_not_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $this->delete($thread->path())->assertRedirect('/login');

        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }

    /** @test */
    function authorized_users_can_delete_threads()
    {
        $this->signIn();

        $thread = create('App\Thread', [ 'user_id' => auth()->id() ]);
        $reply = create('App\Reply', [ 'thread_id' => $thread->id ]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', [ 'id' => $thread->id ]);
        $this->assertDatabaseMissing('replies', [ 'id' => $reply->id ]);

        $this->assertEquals(0, Activity::count());
    }
}
