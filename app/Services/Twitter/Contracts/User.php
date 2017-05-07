<?php

namespace App\Services\Twitter\Contracts;

interface User
{
    /**
     * Get the user id.
     *
     * @return int
     */
    public function id();

    /**
     * Get the user's name.
     *
     * @return string
     */
    public function name();

    /**
     * Get the user's profile image url.
     *
     * @return string
     */
    public function image();

    /**
     * Get the user's profile banner url.
     *
     * @return string
     */
    public function banner();

    /**
     * Get the number of user's tweet.
     *
     * @return int
     */
    public function tweets();

    /**
     * Get the number of user's followers.
     *
     * @return int
     */
    public function followers();

    /**
     * Get the number of user's following.
     *
     * @return int
     */
    public function following();

    /**
     * Get the user's screen name.
     *
     * @return string
     */
    public function screenName();
}
