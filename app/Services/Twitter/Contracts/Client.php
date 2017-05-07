<?php

namespace App\Services\Twitter\Contracts;

interface Client
{
    /**
     * Tweet a new tweet #tweetception.
     *
     * @param  string  $tweet
     * @param  array  $files
     * @return \App\Services\Twitter\Contracts\Tweet
     */
    public function tweet($tweet, array $files = []);

    /**
     * Returns a collection of tweets.
     *
     * @param  int  $numberOfTweets
     * @return \Illuminate\Support\Collection
     */
    public function timeline($numberOfTweets);

    /**
     * Get the authorization url.
     *
     * @param  string  $oauthToken
     * @return string
     */
    public function getAuthorizeUrl($oauthToken);

    /**
     * Get the request token.
     *
     * @param  string  $callbackUrl
     * @return array
     */
    public function getRequestToken($callbackUrl);

    /**
     * Get the access token.
     *
     * @param  string  $oauthVerifier
     * @return array
     */
    public function getAccessToken($oauthVerifier);
}
