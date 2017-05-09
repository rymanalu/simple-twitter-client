<?php

namespace App\Services\Twitter\Clients;

use Carbon\Carbon;
use RuntimeException;
use Thujohn\Twitter\Twitter;
use App\Services\Twitter\Support\User;
use App\Services\Twitter\Support\Tweet;
use Illuminate\Contracts\Session\Session;
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
     * The session implementation.
     *
     * @var \Illuminate\Contracts\Session\Session
     */
    protected $session;

    /**
     * Create a new client instance.
     *
     * @param  \Thujohn\Twitter\Twitter  $twitter
     * @param  \Illuminate\Contracts\Session\Session  $session
     * @return void
     */
    public function __construct(Twitter $twitter, Session $session)
    {
        $this->twitter = $twitter;
    }

    /**
     * Logging in a user.
     *
     * @param  string  $callbackUrl
     * @return void
     * @throws \RuntimeException
     */
    public function login($callbackUrl)
    {
        $this->twitter->reconfig(['token' => '', 'secret' => '']);

        $token = $this->twitter->getRequestToken($callbackUrl);

        if (! isset($token['oauth_token_secret'])) {
            throw new RuntimeException('Cannot request token');
        }

        $url = $this->twitter->getAuthorizeURL($token['oauth_token']);

        $this->session->put([
            'oauth_state' => 'start',
            'oauth_request_token' => $token['oauth_token'],
            'oauth_request_token_secret' => $token['oauth_token_secret']
        ]);
    }

    /**
     * Logging out a user.
     *
     * @return void
     * @throws \RuntimeException
     */
    public function logout()
    {
        //
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
