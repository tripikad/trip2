<?php

return [

    // V2

    'headers' => [
        'default' => 60 * 10,
    ],

    // V1

    'frontpage' => [
        'header' => 60 * 10,
    ],

    'destination' => [
        'header' => 60 * 10,
        'getPopular' => 30, // minutes
    ],

    'content' => [
        'index' => [
            'header' => 60 * 10,
        ],
        'show' => [
            'header' => 60 * 10,
        ],
        'expire' => [
            'comment' => 60 * 24 * 15, // 15 days
        ],
    ],

    'user' => [
        'header' => 60 * 10,
    ],

    'feed' => [
        'atom' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Cache Store
    |--------------------------------------------------------------------------
    |
    | This option controls the default cache connection that gets used while
    | using this caching library. This connection is used when another is
    | not explicitly specified when executing a given caching function.
    |
    */

    'default' => env('CACHE_DRIVER', 'file'),

    /*
    |--------------------------------------------------------------------------
    | Cache Stores
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the cache "stores" for your application as
    | well as their drivers. You may even define multiple stores for the
    | same cache driver to group types of items stored in your caches.
    |
    */

    'stores' => [

        'apc' => [
            'driver' => 'apc',
        ],

        'array' => [
            'driver' => 'array',
        ],

        'database' => [
            'driver' => 'database',
            'table'  => 'cache',
            'connection' => null,
        ],

        'file' => [
            'driver' => 'file',
            'path'   => storage_path('framework/cache'),
        ],

        'memcached' => [
            'driver'  => 'memcached',
            'servers' => [
                [
                    'host' => '127.0.0.1', 'port' => 11211, 'weight' => 100,
                ],
            ],
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'permanent' => [
            'driver' => env('PERMANENT_CACHE_DRIVER', 'array'),
            'connection' => 'permanent',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Key Prefix
    |--------------------------------------------------------------------------
    |
    | When utilizing a RAM based store such as APC or Memcached, there might
    | be other applications utilizing the same cache. So, we'll specify a
    | value to get prefixed to all our keys so we can avoid collisions.
    |
    */

    'prefix' => '',

];
