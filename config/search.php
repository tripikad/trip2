<?php

return [

    'types' => [
        'destination' => [
            'items_per_page' => 20,
            'order' => 'name',
        ],
        'forum' => [
            'items_per_page' => 15,
            'order' => 'updated_at',
            'order_type' => 'desc',
        ],
        'user' => [
            'items_per_page' => 15,
            'order' => 'name',
        ],
        'blog' => [
            'items_per_page' => 15,
            'order' => 'updated_at',
            'order_type' => 'desc',
        ],
        'news' => [
            'items_per_page' => 10,
            'order' => 'updated_at',
            'order_type' => 'desc',
        ],
        'flight' => [
            'items_per_page' => 15,
            'order' => 'updated_at',
            'order_type' => 'desc',
        ],
    ],
    'length' => 2,
    'ajaxResults' => 8,

];
