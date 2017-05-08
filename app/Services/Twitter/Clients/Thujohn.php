<?php

namespace App\Services\Twitter\Clients;

use Carbon\Carbon;
use Thujohn\Twitter\Twitter;
use App\Services\Twitter\Support\User;
use App\Services\Twitter\Support\Tweet;
use App\Services\Twitter\Contracts\Client;

class Thujohn implements Client
{
    /**
     * The Thujohn's Twitter instance.
     *
     * @var \Thujohn\Twitter\Twitter
     */
    protected $twitter;

    /**
     * Create a new client instance.
     *
     * @param  \Thujohn\Twitter\Twitter  $twitter
     * @return void
     */
    public function __construct(Twitter $twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * Returns a collection of tweets.
     *
     * @param  int  $count
     * @return \Illuminate\Support\Collection
     */
    public function timeline($count)
    {
        return collect($this->twitter->getHomeTimeline(compact('count')))->transform(function ($tweet) {
            return $this->createTweet($tweet);
        });
    }

    /**
     * Get the authorization url.
     *
     * @param  string  $oauthToken
     * @return string
     */
    public function getAuthorizeUrl($oauthToken)
    {
        return $this->twitter->getAuthorizeURL($oauthToken);
    }

    /**
     * Get the request token.
     *
     * @param  string  $callbackUrl
     * @return array
     */
    public function getRequestToken($callbackUrl)
    {
        return $this->twitter->getRequestToken($callbackUrl);
    }

    /**
     * Get the access token.
     *
     * @param  string  $oauthVerifier
     * @return array
     */
    public function getAccessToken($oauthVerifier)
    {
        return $this->twitter->getAccessToken($oauthVerifier);
    }

    /**
     * Tweet a new tweet #tweetception.
     *
     * @param  string  $status
     * @param  array  $files
     * @return \App\Services\Twitter\Contracts\Tweet
     */
    public function tweet($status, array $files = [])
    {
        $tweet = compact('status');

        foreach ($files as $file) {
            $uploadedMedia = $this->twitter->uploadMedia(['media' => $file, 'format' => 'array']);

            if (! empty($uploadedMedia)) {
                $tweet['media_ids'][$uploadedMedia->media_id_string] = $uploadedMedia->media_id_string;
            }
        }

        return $this->createTweet($this->twitter->postTweet($tweet));
    }

    /**
     * Get the time ago format by given time.
     *
     * @param  string  $time
     * @return string
     */
    protected function getTimeAgo($time)
    {
        return twitter_time_ago(Carbon::createFromFormat('D M d H:i:s O Y', $time));
    }

    /**
     * Create a tweet instance from given tweet.
     *
     * @param  object  $tweet
     * @return \App\Services\Twitter\Contracts\Tweet
     */
    protected function createTweet($tweet)
    {
        return new Tweet(
            $tweet->id, $tweet->text, $this->getTimeAgo($tweet->created_at), $this->createUser($tweet)
        );
    }

    /**
     * Create a user instance from given tweet.
     *
     * @param  object  $tweet
     * @return \App\Services\Twitter\Contracts\User
     */
    protected function createUser($tweet)
    {
        return new User(
            $tweet->user->id, $tweet->user->name, $tweet->user->profile_image_url, $tweet->user->profile_banner_url,
            $tweet->user->statuses_count, $tweet->user->followers_count, $tweet->user->friends_count, $tweet->user->screen_name
        );
    }
}
