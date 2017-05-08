<?php

namespace App\Services\Twitter\Support;

use App\Services\Twitter\Contracts\User as UserContract;

class User implements UserContract
{
    /**
     * Id of the user.
     *
     * @var int
     */
    protected $id;

    /**
     * User's name.
     *
     * @var string
     */
    protected $name;

    /**
     * User's image url.
     *
     * @var string
     */
    protected $image;

    /**
     * User's banner url.
     *
     * @var string
     */
    protected $banner;

    /**
     * Number of user's tweets.
     *
     * @var int
     */
    protected $tweets;

    /**
     * Number of user's followers.
     *
     * @var int
     */
    protected $followers;

    /**
     * Number of the user's following.
     *
     * @var int
     */
    protected $following;

    /**
     * User's screenname.
     *
     * @var string
     */
    protected $screenName;

    /**
     * Create a new User instance.
     *
     * @param  int  $id
     * @param  string  $name
     * @param  string  $image
     * @param  string  $banner
     * @param  int  $tweets
     * @param  int  $followers
     * @param  int  $following
     * @param  string  $screenName
     * @return void
     */
    public function __construct($id, $name, $image, $banner, $tweets, $followers, $following, $screenName)
    {
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
        $this->banner = $banner;
        $this->tweets = $tweets;
        $this->followers = $followers;
        $this->following = $following;
        $this->screenName = $screenName;
    }

    /**
     * Get the user id.
     *
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Get the user's name.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Get the user's profile image url.
     *
     * @return string
     */
    public function image()
    {
        return $this->image;
    }

    /**
     * Get the user's profile banner url.
     *
     * @return string
     */
    public function banner()
    {
        return $this->banner;
    }

    /**
     * Get the number of user's tweet.
     *
     * @return int
     */
    public function tweets()
    {
        return $this->tweets;
    }

    /**
     * Get the number of user's followers.
     *
     * @return int
     */
    public function followers()
    {
        return $this->followers;
    }

    /**
     * Get the number of user's following.
     *
     * @return int
     */
    public function following()
    {
        return $this->following;
    }

    /**
     * Get the user's screen name.
     *
     * @return string
     */
    public function screenName()
    {
        return $this->screenName;
    }
}
