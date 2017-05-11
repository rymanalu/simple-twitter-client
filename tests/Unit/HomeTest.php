<?php

namespace Tests\Unit;

use Twitter;
use Tests\TestCase;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomeTest extends TestCase
{
    public function testRedirectToErrorRouteWhenSessionHasNoAccessToken()
    {
        $response = $this->get('home');

        $response->assertStatus(302);
        $response->assertRedirect(route('auth::error'));
        $response->assertSessionHas('message', 'please login');
    }

    public function testGetTweetsAndDisplayThemInTheView()
    {
        Twitter::shouldReceive('getHomeTimeline')->with(['count' => 50])->andReturn($this->getTweets());

        $response = $this->withSession(['access_token' => 'access_token'])->get('home');

        $response->assertStatus(200);
        $response->assertViewHas('tweets');
    }

    protected function getTweets()
    {
        $faker = Faker::create();
        $tweets = [];

        for ($i = 0; $i < 50; $i++) {
            $tweets[] = (object) [
                'id' => $faker->randomNumber(),
                'text' => $faker->text,
                'created_at' => date('D M d H:i:s O Y'),
                'user' => (object) [
                    'name' => $faker->name,
                    'screen_name' => $faker->userName,
                    'profile_image_url' => $faker->imageUrl,
                ],
            ];
        }

        return $tweets;
    }
}
