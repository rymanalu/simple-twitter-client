<?php

namespace App\Http\Controllers;

use File;
use Twitter;
use App\Http\Requests\TweetRequest;

class TweetController extends Controller
{
    public function store(TweetRequest $request)
    {
        $tweet = ['status' => $request->input('tweet')];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $uploadedMedia = Twitter::uploadMedia(['media' => File::get($file->getRealPath())]);

                if (! empty($uploadedMedia)) {
                    $tweet['media_ids'][$uploadedMedia->media_id_string] = $uploadedMedia->media_id_string;
                }
            }
        }

        Twitter::postTweet($tweet);

        return redirect()->route('home')->with('message', 'Tweet created');
    }
}
