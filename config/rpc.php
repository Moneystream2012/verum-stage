<?php

return [

    'client' => [
        /*
         * Server URL
         */
        'url' => env('RPC_URL', 'http://example.com/jsonrpc'),

        /*
         * HTTP client timeout
         */
        'timeout'    => env('RPC_TIMEOUT', 15),

        /*
         * Custom HTTP headers
         */
        'headers'    => [],

        /*
         * Username for authentication
         */
        'username' => env('RPC_USERNAME', false),
        'password' => env('RPC_PASSWORD'),

        /*
         * Enable debug output to the php error log
         */
        'debug' => env('RPC_DEBUG', true),

        /*
         * SSL certificates verification
         */
        'ssl_verify_peer' => env('RPC_SSL', false),

        /*
         * Methods to Cache
         * '*' to allow all, and 'method_name' to single method
         */
        'cache' => env('RPC_CACHE', null),

        'cache_duration' => env('RPC_CACHE_TIME', 15),
    ],

    'server' => [
    ],

];
