<?php

namespace App\Services\Twitter;

use RuntimeException;
use App\Services\Twitter\Contracts\Client;

class Twitter
{
    /**
     * The client implementation.
     *
     * @var \App\Services\Twitter\Contracts\Client
     */
    protected static $client;

    /**
     * Set the client implementation for the factory.
     *
     * @param  \App\Services\Twitter\Contracts\Client  $client
     * @return void
     */
    public static function setClient(Client $client)
    {
        static::$client = $client;
    }

    /**
     * Handle dynamic static method calls to the client.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        if (isset(static::$client)) {
            return static::$client->{$method}(...$parameters);
        }

        $class = Client::class;

        throw new RuntimeException("Twitter client is not an instance of {$class}");
    }
}
