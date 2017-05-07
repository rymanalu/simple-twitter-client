<?php

namespace App\Http\Controllers;

use Twitter;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameters = ['count' => 50];

        $tweets = collect(Twitter::getHomeTimeline($parameters))->transform(function ($tweet) {
            return (object) [
                'id' => $tweet->id,
                'text' => $tweet->text,
                'created_at' => twitter_time_ago(Carbon::createFromFormat('D M d H:i:s O Y', $tweet->created_at)),
                'user' => [
                    'name' => $tweet->user->name,
                    'screen_name' => $tweet->user->screen_name,
                    'profile_image_url' => $tweet->user->profile_image_url,
                ],
            ];
        });

        return view('home', compact('tweets'));
    }
}
