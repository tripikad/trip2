<?php

return [

    'types' => [
        'forum' => [
            'items_per_page' => 15,
            'order' => 'updated_at',
            'order_type' => 'desc',
        ],
        'news' => [
            'items_per_page' => 10,
            'order' => 'created_at',
            'order_type' => 'desc',
        ],
        'destination' => [
            'items_per_page' => 20,
            'order' => 'name',
        ],
        // 'blog' => [
        //     'items_per_page' => 15,
        //     'order' => 'updated_at',
        //     'order_type' => 'desc',
        // ],
        'flight' => [
            'items_per_page' => 15,
            'order' => 'created_at',
            'order_type' => 'desc',
        ],
        'user' => [
            'items_per_page' => 15,
            'order' => 'name',
        ],
    ],
    'ajax_results' => 8,

];
