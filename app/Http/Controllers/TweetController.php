<?php

namespace App\Http\Controllers;

use File;
use App\Http\Requests\TweetRequest;
use Thujohn\Twitter\Facades\Twitter;

class TweetController extends Controller
{
    /**
     * Post a new tweet.
     *
     * @param  \App\Http\Requests\TweetRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TweetRequest $request)
    {
        $tweet = ['status' => $request->input('tweet')];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $uploadedMedia = Twitter::uploadMedia(['media' => File::get($file->getRealPath()), 'format' => 'array']);

                if (! empty($uploadedMedia)) {
                    $tweet['media_ids'][$uploadedMedia->media_id_string] = $uploadedMedia->media_id_string;
                }
            }
        }

        Twitter::postTweet($tweet);

        return redirect()->route('home')->with('message', 'Tweet created');
    }
}
