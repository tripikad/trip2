<?php

return [

    'index' => [

        'with' => ['destinations', 'topics'],
        'orderBy' => [
            'field' => 'created_at',
            'order' => 'desc',
        ],
        'paginate' => 25,
    ],

    'edit' => [

        'fields' => [
            'title' => [
                'type' => 'text',
                'title' => 'Title',
            ],
            'body' => [
                'type' => 'textarea',
                'title' => 'Body',
                'large' => true,
            ],
            'submit' => [
                'type' => 'submit',
                'title' => 'Add',
            ],
        ],

        'validate' => [

            'title' => 'required',
            'body' => 'required',

        ],

    ],

];
