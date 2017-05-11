<?php

namespace Tests\Unit;

use Session;
use Twitter;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CallbackTest extends TestCase
{
    public function testRedirectToErrorRouteWhenSessionHasNoOauthRequestToken()
    {
        $response = $this->get('auth/callback');

        $response->assertStatus(302);
        $response->assertRedirect(route('auth::error'));
        $response->assertSessionHas('message', 'something went wrong');
    }

    public function testRedirectToErrorRouteWhenOauthVerifierIsNotExists()
    {
        $sessionData = ['oauth_request_token' => 'token', 'oauth_request_token_secret' => 'secret'];

        Twitter::shouldReceive('reconfig')->with(['token' => $sessionData['oauth_request_token'], 'secret' => $sessionData['oauth_request_token_secret']]);

        $response = $this->withSession($sessionData)->get('auth/callback');

        $response->assertStatus(302);
        $response->assertRedirect(route('auth::error'));
        $response->assertSessionHas('message', 'authorization failed');
    }

    public function testRedirectToErrorRouteWhenOauthTokenSecretIsNotExists()
    {
        $sessionData = ['oauth_request_token' => 'token', 'oauth_request_token_secret' => 'secret'];

        Twitter::shouldReceive('reconfig')->with(['token' => $sessionData['oauth_request_token'], 'secret' => $sessionData['oauth_request_token_secret']]);
        Twitter::shouldReceive('getAccessToken')->with('oauth_verifier')->andReturn([]);

        $response = $this->withSession($sessionData)->call('GET', 'auth/callback', ['oauth_verifier' => 'oauth_verifier']);

        $response->assertStatus(302);
        $response->assertRedirect(route('auth::error'));
        $response->assertSessionHas('message', 'authorization failed');
    }

    public function testRedirectToErrorRouteWhenGetCredentialsReturnAnError()
    {
        $sessionData = ['oauth_request_token' => 'token', 'oauth_request_token_secret' => 'secret'];

        Twitter::shouldReceive('reconfig')->with(['token' => $sessionData['oauth_request_token'], 'secret' => $sessionData['oauth_request_token_secret']]);
        Twitter::shouldReceive('getAccessToken')->with('oauth_verifier')->andReturn(['oauth_token_secret' => 'oauth_token_secret']);
        Twitter::shouldReceive('getCredentials')->andReturn((object) ['error' => 'error']);

        $response = $this->withSession($sessionData)->call('GET', 'auth/callback', ['oauth_verifier' => 'oauth_verifier']);

        $response->assertStatus(302);
        $response->assertRedirect(route('auth::error'));
        $response->assertSessionHas('message', 'something went wrong');
    }

    public function testCallbackSuccessfullyHandled()
    {
        $sessionData = ['oauth_request_token' => 'token', 'oauth_request_token_secret' => 'secret'];
        $accessToken = ['oauth_token_secret' => 'oauth_token_secret'];
        $user = [
            'id' => 12, 'name' => 'Roni Yusuf', 'screen_name' => 'rymanalu', 'friends_count' => 0, 'statuses_count' => 0, 'followers_count' => 0, 'profile_image_url' => 'profile_image_url', 'profile_banner_url' => 'profile_banner_url',
        ];

        Twitter::shouldReceive('reconfig')->with(['token' => $sessionData['oauth_request_token'], 'secret' => $sessionData['oauth_request_token_secret']]);
        Twitter::shouldReceive('getAccessToken')->with('oauth_verifier')->andReturn($accessToken);
        Twitter::shouldReceive('getCredentials')->andReturn((object) $user);

        $response = $this->withSession($sessionData)->call('GET', 'auth/callback', ['oauth_verifier' => 'oauth_verifier']);

        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
        $response->assertSessionHas('user', $user);
        $response->assertSessionHas('message', 'success login');
        $response->assertSessionHas('access_token', $accessToken);
    }
}
