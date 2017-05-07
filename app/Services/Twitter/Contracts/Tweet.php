<?php

namespace App\Services\Twitter\Contracts;

interface Tweet
{
    /**
     * Get the tweet id.
     *
     * @return int
     */
    public function id();

    /**
     * Get the text of the tweet.
     *
     * @return string
     */
    public function text();

    /**
     * Get the time that the tweet was created.
     *
     * @return string
     */
    public function time();

    /**
     * Get the user who owns the tweet.
     *
     * @return \App\Services\Twitter\Contracts\User
     */
    public function user();
}
