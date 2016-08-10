<?php

return [

    'index' => [

        'with' => ['images', 'topics'],
        'orderBy' => [
            'field' => 'created_at',
            'order' => 'desc',
        ],
        'expire' => [
            'field' => 'end_at',
            'daysFrom' => 'end_at',
            'daysTo' => -700000000,
            'type' => 'datetime',
        ],
        'paginate' => 15,
    ],

    'edit' => [

        'fields' => [
            'title' => [
                'type' => 'text',
            ],
            'image_id' => [
                'type' => 'image_id',
            ],
            'body' => [
                'type' => 'textarea',
                'rows' => 16,
                'large' => true,
                'wysiwyg' => true,
            ],
            'destinations' => [
                'type' => 'destinations',
            ],
            'start_at' => [
                'type' => 'datetime',
            ],
            'end_at' => [
                'type' => 'datetime',
            ],
            'price' => [
                'type' => 'currency',
            ],
            'url' => [
                'type' => 'url',
            ],
            'submit' => [
                'type' => 'submit',
            ],
        ],

        'validate' => [

            'title' => 'required',
            'body' => 'required',
            'url' => 'url',
            'start_at' => 'date|required',
            'end_at' => 'date|required',
            'price' => 'integer',

        ],

    ],

];
