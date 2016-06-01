<?php

return [

    'header' => [
        'home' => [
            'route' => '/',
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
    ],

    'footer' => [
        'flights' => [
            'route' => '/content/flight',
        ],
        'travelmates' => [
            'route' => '/content/travelmate',
        ],
        'news' => [
            'route' => '/content/news',
        ],
        'blogs' => [
            'route' => '/content/blog',
        ],
        'photos' => [
            'route' => '/content/photo',
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
            'title' => 'menu.news.news',
            'route' => '/content/news',
            'modifiers' => 'm-large m-block m-icon',
            'icon' => 'icon-arrow-right',
            'type' => 'news',
        ],
        'shortnews' => [
            'title' => 'menu.news.shortnews',
            'route' => '/content/shortnews',
            'modifiers' => 'm-large m-block m-icon',
            'icon' => 'icon-arrow-right',
            'type' => 'shortnews',
        ],
    ],

    'forum' => [
        [
            'title' => 'menu.forum.forum',
            'route' => '/content/forum',
            'modifiers' => 'm-large m-block m-icon',
            'icon' => 'icon-arrow-right',
            'type' => 'forum',
        ],
        [
            'title' => 'menu.forum.expat',
            'route' => '/content/expat',
            'modifiers' => 'm-large m-block m-icon',
            'icon' => 'icon-arrow-right',
            'type' => 'expat',
        ],
        [
            'title' => 'menu.forum.buysell',
            'route' => '/content/buysell',
            'modifiers' => 'm-large m-block m-icon',
            'icon' => 'icon-arrow-right',
            'type' => 'buysell',
        ],
    ],

    'admin' => [
        [
            'title' => 'menu.admin.internal',
            'route' => '/content/internal',
            'modifiers' => 'm-large m-block m-icon',
            'icon' => 'icon-arrow-right',
        ],
        [
            'title' => 'menu.admin.image',
            'route' => '/admin/image',
            'modifiers' => 'm-large m-block m-icon',
            'icon' => 'icon-arrow-right',
        ],
        [
            'title' => 'menu.admin.content',
            'route' => '/admin/content',
            'modifiers' => 'm-large m-block m-icon',
            'icon' => 'icon-arrow-right',
        ],
    ],

];
