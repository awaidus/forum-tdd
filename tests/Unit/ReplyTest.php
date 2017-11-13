<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function it_has_a_user()
    {
        $reply = factory('App\Reply')->create();

        $this->assertInstanceOf('App\User', $reply->user);

    }
}
