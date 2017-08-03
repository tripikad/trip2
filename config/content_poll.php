<?php

return [

    'edit' => [

        'fields' => [
            'poll_type' => [
                'type' => 'radio',
                'title' => 'Poll type',
                'items' => 'menu.poll',
            ],
            'start' => [
                'type' => 'date',
                'title' => 'Start date',
            ],
            'end' => [
                'type' => 'date',
                'title' => 'End date',
            ],
            'destinations' => [
                'type' => 'destinations',
                'title' => 'index.filter.field.destination.title',
            ],
        ],
    ],

];
