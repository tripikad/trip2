@include('component.content.forum.list', [
    'modifiers' => 'm-compact',
    'items' => $items->transform(function($item) {
        if($item->activity_type == 'content') {

            return [
                'topic' => $item->title,
                'route' => route($item->type.'.show', [$item->slug]),
                'profile' => [
                    'modifiers' => 'm-mini',
                    'image' => $item->user->imagePreset(),
                    'letter' => [
                        'modifiers' => 'm-green m-small',
                        'text' => 'D'
                    ],
                ],
                'badge' => [
                    'modifiers' => 'm-mini',
                    'count' => $item->comments->count()
                ],
                'children' => [
                    [
                        'profile' => [
                            'image' => $item->user->imagePreset(),
                            'title' => $item->user->title,
                            'route' => ($item->user->name != 'Tripi külastaja' ? route('user.show', [$item->user]) : false),
                            'letter' => [
                                'modifiers' => 'm-green m-small',
                                'text' => 'D'
                            ],
                            'status' => [
                                'modifiers' => 'm-green',
                                'position' => '1'
                            ]
                        ],
                        'date' => view('component.date.long', [
                            'date' => $item->created_at
                        ]),
                        'text' => $item->body,
                        'more' => [
                            'title' => trans('user.activity.view.full.post'),
                            'route' => route($item->type.'.show', [$item->slug])
                        ]
                    ]
                ]
            ];

        } else {

            return [
                'topic' => $item->content->title,
                'route' => route($item->content->type.'.show', [$item->content->slug]),
                'profile' => [
                    'modifiers' => 'm-mini',
                    'image' => $item->content->user->imagePreset(),
                    'letter' => [
                        'modifiers' => 'm-green m-small',
                        'text' => 'D'
                    ],
                ],
                'badge' => [
                    'modifiers' => 'm-mini',
                    'count' => $item->content->comments->count()
                ],
                'children' => [
                    [
                        'profile' => [
                            'image' => $item->user->imagePreset(),
                            'title' => $item->user->title,
                            'route' => route('user.show', [$item->user]),
                            'letter' => [
                                'modifiers' => 'm-green m-small',
                                'text' => 'D'
                            ],
                            'status' => [
                                'modifiers' => 'm-green',
                                'position' => '1'
                            ]
                        ],
                        'date' => view('component.date.long', [
                            'date' => $item->created_at
                        ]),
                        'text' => $item->body_filtered,
                        'more' => [
                            'title' => trans('user.activity.view.full.post'),
                            'route' => route($item->content->type.'.show', [$item->content->slug, '#comment-' . $item->id])
                        ]
                    ]
                ]
            ];
        }
    })
])
