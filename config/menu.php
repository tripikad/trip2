<?php

return [

    'header' => [
        'home' => [
            'route' => '/',
        ],
        'news' => [
            'route' => '/content/news',
        ],
       'flights' => [
            'route' => '/content/flight',
        ],
        'travelmates' => [
            'route' => '/content/travelmate',
        ],
        'forum' => [
            'route' => '/content/forum',
        ],
        'photos' => [
            'route' => '/content/photo',
        ],
        'blogs' => [
            'route' => '/content/blog',
        ],
        'offers' => [
            'route' => 'http://vana.trip.ee/reisipakkumised',
            'external' => true,
        ],
    ],

    'footer' => [
        'news' => [
            'route' => '/content/news',
        ],
        'flights' => [
            'route' => '/content/flight',
        ],
        'offers' => [
            'route' => 'http://vana.trip.ee/reisipakkumised',
            'external' => true,
        ],
        'travelmates' => [
            'route' => '/content/travelmate',
        ],
    ],

    'footer2' => [
        'forum' => [
            'route' => '/content/forum',
        ],
        'expat' => [
            'route' => '/content/expat',
        ],
        'buysell' => [
            'route' => '/content/buysell',
        ],
    ],

    'footer3' => [
        'about' => [
            'route' => '/content/static/1534',
        ],
        'contact' => [
            'route' => '/content/static/972',
        ],
        'eula' => [
            'route' => '/content/static/25151',
        ],
        'advertising' => [
            'route' => '/content/static/22125',
        ],
        'styleguide' => [
            'route' => '/styleguide',
        ],
    ],

    'footer-social' => [
        'facebook' => [
            'route' => 'https://facebook.com/tripeeee',
            'external' => true,
            'icon' => 'icon-facebook',
        ],
        'twitter' => [
            'route' => 'https://twitter.com/trip_ee',
            'external' => true,
            'icon' => 'icon-twitter',
        ],
    ],

    'news' => [
        'news' => [
            'route' => '/content/news',
        ],
        'shortnews' => [
            'route' => '/content/shortnews',
        ],
    ],

    'forum' => [
        'forum' => [
            'route' => '/content/forum',
        ],
        'expat' => [
            'route' => '/content/expat',
        ],
        'buysell' => [
            'route' => '/content/buysell',
        ],
    ],

    'admin' => [
        'internal' => [
            'route' => '/content/internal',
        ],
        'sponsored' => [
            'route' => '/content/sponsored',
        ],
        'image' => [
            'route' => '/admin/image',
        ],
        'content' => [
            'route' => '/admin/content',
        ],
    ],

];
