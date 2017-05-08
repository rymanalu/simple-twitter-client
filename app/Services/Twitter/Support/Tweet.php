<?php

namespace App\Services\Twitter\Support;

use App\Services\Twitter\Contracts\Tweet as TweetContract;

class Tweet implements TweetContract
{
    /**
     * Id of the tweet.
     *
     * @var int
     */
    protected $id;

    /**
     * Text of the tweet.
     *
     * @var string
     */
    protected $text;

    /**
     * Time when the tweet created.
     *
     * @var string
     */
    protected $time;

    /**
     * The User implementation.
     *
     * @var \App\Services\Twitter\Support\User
     */
    protected $user;

    /**
     * Create a new Tweet instance.
     *
     * @param  int  $id
     * @param  string  $text
     * @param  string  $time
     * @param  \App\Services\Twitter\Support\User  $user
     * @return void
     */
    public function __construct($id, $text, $time, User $user)
    {
        $this->id = $id;
        $this->text = $text;
        $this->time = $time;
        $this->user = $user;
    }

    /**
     * Get the tweet id.
     *
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Get the text of the tweet.
     *
     * @return string
     */
    public function text()
    {
        return $this->text;
    }

    /**
     * Get the time that the tweet was created.
     *
     * @return string
     */
    public function time()
    {
        return $this->time;
    }

    /**
     * Get the user who owns the tweet.
     *
     * @return \App\Services\Twitter\Contracts\User
     */
    public function user()
    {
        return $this->user;
    }
}
