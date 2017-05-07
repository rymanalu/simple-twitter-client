<?php

namespace App\Http\Controllers;

use Twitter;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        Twitter::reconfig(['token' => '', 'secret' => '']);

        $token = Twitter::getRequestToken(route('auth::callback'));

        if (! isset($token['oauth_token_secret'])) {
            return redirect()->route('auth::error');
        }

        $url = Twitter::getAuthorizeURL($token);

        $request->session()->put([
            'oauth_state' => 'start',
            'oauth_request_token' => $token['oauth_token'],
            'oauth_request_token_secret' => $token['oauth_token_secret']
        ]);

        return redirect($url);
    }

    public function callback(Request $request)
    {
        if ($request->session()->has('oauth_request_token')) {
            Twitter::reconfig([
                'token' => $request->session()->get('oauth_request_token'),
                'secret' => $request->session()->get('oauth_request_token_secret'),
            ]);

            if ($request->has('oauth_verifier')) {
                $token = Twitter::getAccessToken($request->input('oauth_verifier'));
            }

            if (! isset($token['oauth_token_secret'])) {
                return redirect()->route('auth::error')->with('message', 'error at oauth_token_secret');
            }

            $credentials = Twitter::getCredentials();

            if (is_object($credentials) && ! isset($credentials->error)) {
                $request->session()->put('access_token', $token);

                $request->session()->put('user', [
                    'id' => $credentials->id,
                    'name' => $credentials->name,
                    'screen_name' => $credentials->screen_name,
                    'friends_count' => $credentials->friends_count,
                    'statuses_count' => $credentials->statuses_count,
                    'followers_count' => $credentials->followers_count,
                    'profile_image_url' => $credentials->profile_image_url,
                    'profile_banner_url' => $credentials->profile_banner_url,
                ]);

                return redirect()->route('home')->with('message', 'success login');
            }
        }

        return redirect()->route('auth::error')->with('message', 'something went wrong');
    }

    public function error(Request $request)
    {
        return view('errors.twitter', ['message' => $request->session()->get('message')]);
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['access_token', 'user']);

        return redirect()->route('auth::error')->with('message', 'success logout');
    }
}
