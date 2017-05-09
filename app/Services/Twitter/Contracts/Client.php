<?php

namespace App\Services\Twitter\Contracts;

interface Client
{
    /**
     * Logging in a user.
     *
     * @param  string  $callbackUrl
     * @return void
     * @throws \RuntimeException
     */
    public function login($callbackUrl);

    /**
     * Logging out a user.
     *
     * @return void
     * @throws \RuntimeException
     */
    public function logout();

    /**
     * Returns a collection of tweets.
     *
     * @param  int  $count
     * @return \Illuminate\Support\Collection
     */
    public function timeline($count);

    /**
     * Tweet a new tweet #tweetception.
     *
     * @param  string  $status
     * @param  array  $files
     * @return \App\Services\Twitter\Contracts\Tweet
     */
    public function tweet($status, array $files = []);
}
