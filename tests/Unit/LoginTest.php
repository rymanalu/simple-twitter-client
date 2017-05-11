<?php

namespace Tests\Unit;

use Twitter;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    public function testRedirectToErrorRouteWhenTokenSecretIsEmpty()
    {
        Twitter::shouldReceive('reconfig');
        Twitter::shouldReceive('getRequestToken')->with(route('auth::callback'))->andReturn([]);

        $response = $this->get('auth/login');

        $response->assertStatus(302);
        $response->assertRedirect(route('auth::error'));
        $response->assertSessionHas('message', 'Failed to request token');
    }

    public function testRedirectToTwitterAuthorizationPage()
    {
        $token = [
            'oauth_token' => 'foo',
            'oauth_token_secret' => 'bar',
        ];

        Twitter::shouldReceive('reconfig');
        Twitter::shouldReceive('getRequestToken')->with(route('auth::callback'))->andReturn($token);
        Twitter::shouldReceive('getAuthorizeURL')->with($token['oauth_token'])->andReturn('http://foobar.dev/foo/bar');

        $response = $this->get('auth/login');

        $response->assertStatus(302);
        $response->assertRedirect('http://foobar.dev/foo/bar');
        $response->assertSessionHas('oauth_state', 'start');
        $response->assertSessionHas('oauth_request_token', $token['oauth_token']);
        $response->assertSessionHas('oauth_request_token_secret', $token['oauth_token_secret']);
    }
}
