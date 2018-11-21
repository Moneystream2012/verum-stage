<?php

namespace App\Extensions;

use Illuminate\Contracts\Cache\Store;
use Tarantool\Client\Client;
use Tarantool\Client\Connection\StreamConnection;
use Tarantool\Client\Packer\PurePacker;

class TarantoolStore implements Store
{
    private $client;

    public function __construct()
    {
        $conn = new StreamConnection(config('cache.stores.tarantool.url'), config('cache.stores.tarantool.options'));
        $this->client = new Client($conn, new PurePacker());
        $this->client->authenticate(config('cache.stores.tarantool.username'), config('cache.stores.tarantool.password'));
    }

    public function getCall($funcName, array $args = [])
    {
        $res = $this->client->call($funcName, $args);
        if (isset($res->getData()[0])) {
            return $res->getData()[0];
        }
    }

    public function get($key)
    {
    }

    public function put($key, $value, $minutes)
    {
    }

    public function increment($key, $value = 1)
    {
    }

    public function decrement($key, $value = 1)
    {
    }

    public function forever($key, $value)
    {
    }

    public function forget($key)
    {
    }

    public function flush()
    {
    }

    public function getPrefix()
    {
    }

    public function many(array $keys)
    {
    }

    public function putMany(array $values, $minutes)
    {
    }
}
