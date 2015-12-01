<?php

return [

    'frontpage' => [

        'show' => true,
        'with' => ['images'],
        'latest' => 'created_at',
        'take' => 8,
    ],

    'index' => [

        'with' => ['images'],
        'latest' => 'end_at',
        'paginate' => 24,
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
