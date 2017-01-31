<?php

return [

    'header' => [
        'home' => [
            'route' => '/',
        ],
       'flights' => [
            'route' => '/odavad-lennupiletid',
        ],
        'travelmates' => [
            'route' => '/reisikaaslased',
        ],
        'forum' => [
            'route' => '/foorum/uldfoorum',
        ],
    ],

    'footer' => [
        'flights' => [
            'route' => '/odavad-lennupiletid',
        ],
        'travelmates' => [
            'route' => '/reisikaaslased',
        ],
        'news' => [
            'route' => '/uudised',
        ],
        'blogs' => [
            'route' => '/reisikirjad',
        ],
        'photos' => [
            'route' => '/reisipildid',
        ],

    ],

    'footer2' => [
        'forum' => [
            'route' => '/foorum/uldfoorum',
        ],
        'expat' => [
            'route' => '/foorum/elu-valimaal',
        ],
        'buysell' => [
            'route' => '/foorum/ost-muuk',
        ],

    ],

    'footer3' => [
        'about' => [
            'route' => '/tripist',
        ],
        'contact' => [
            'route' => '/kontakt',
        ],
        'eula' => [
            'route' => '/kasutustingimused',
        ],
        'advertising' => [
            'route' => '/reklaam',
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
        'flightfeed' => [
            'route' => '/lendude_sooduspakkumised/rss',
            'external' => true,
            'icon' => 'icon-rss',
        ],
        'newsfeed' => [
            'route' => '/index.atom',
            'external' => true,
            'icon' => 'icon-rss',
        ],
    ],

    'news' => [
        'news' => [
            'title' => 'menu.news.news',
            'route' => '/uudised',
            'modifiers' => 'm-large m-block m-icon',
            'icon' => 'icon-arrow-right',
            'type' => 'news',
        ],
        'shortnews' => [
            'title' => 'menu.news.shortnews',
            'route' => '/luhiuudised',
            'modifiers' => 'm-large m-block m-icon',
            'icon' => 'icon-arrow-right',
            'type' => 'shortnews',
        ],
    ],

    'forum' => [
        [
            'title' => 'menu.forum.forum',
            'route' => '/foorum/uldfoorum',
            'modifiers' => 'm-large m-block m-icon',
            'icon' => 'icon-arrow-right',
            'type' => 'forum',
        ],
        [
            'title' => 'menu.forum.expat',
            'route' => '/foorum/elu-valimaal',
            'modifiers' => 'm-large m-block m-icon',
            'icon' => 'icon-arrow-right',
            'type' => 'expat',
        ],
        [
            'title' => 'menu.forum.buysell',
            'route' => '/foorum/ost-muuk',
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
