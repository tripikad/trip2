<?php

return [

    'index' => [

        'with' => ['destinations', 'topics'],
        'orderBy' => [
            'field' => 'created_at',
            'order' => 'desc',
        ],
        'paginate' => 24,
    ],

    'store' => [

        'status' => 1,

    ],

    'edit' => [

        'fields' => [
            'type' => [
                'type' => 'radio',
                'items' => 'menu.news',
            ],
            'title' => [
                'type' => 'text',
                'title' => 'Title',
            ],
            'image_id' => [
                'type' => 'image_id',
            ],
            'body' => [
                'type' => 'textarea',
                'title' => 'Body',
                'rows' => 16,
                'large' => true,
                'wysiwyg' => true,
            ],
            'destinations' => [
                'type' => 'destinations',
            ],
            'topics' => [
                'type' => 'topics',
            ],
            'url' => [
                'type' => 'url',
                'title' => 'URL',
            ],
            'submit' => [
                'type' => 'submit',
                'title' => 'Add',
            ],
        ],

        'validate' => [

            'title' => 'required',
            'url' => 'url',
            'file' => 'image',

        ],

    ],

];
