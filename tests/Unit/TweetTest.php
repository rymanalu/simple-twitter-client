<?php

namespace Tests\Unit;

use Twitter;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TweetTest extends TestCase
{
    public function testPostANewTweet()
    {
        Twitter::shouldReceive('postTweet')->with(['status' => 'Test']);

        $response = $this->post('tweet', ['tweet' => 'Test']);

        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
        $response->assertSessionHas('message', 'Tweet created');
    }
}
