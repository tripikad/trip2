@include('component.content.forum.list', [
    'modifiers' => 'm-compact',
    'items' => $items->transform(function($item) {
        if($item->activity_type == 'content') {

            return [
                'topic' => $item->title,
                'route' => route('content.show', [$item->type, $item]),
                'profile' => [
                    'modifiers' => 'm-mini',
                    'image' => $item->user->imagePreset()
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
                            'route' => route('user.show', [$item->user])
                        ],
                        'date' => view('component.date.long', [
                            'date' => $item->created_at
                        ]),
                        'text' => $item->body,
                        'more' => [
                            'title' => trans('user.activity.view.full.post'),
                            'route' => route('content.show', [$item->type, $item])
                        ]
                    ]
                ]
            ];

        } else {

            return [
                'topic' => $item->content->title,
                'route' => route('content.show', [$item->content->type, $item->content]),
                'profile' => [
                    'modifiers' => 'm-mini',
                    'image' => $item->content->user->imagePreset()
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
                            'route' => route('user.show', [$item->user])
                        ],
                        'date' => view('component.date.long', [
                            'date' => $item->created_at
                        ]),
                        'text' => $item->body_filtered,
                        'more' => [
                            'title' => trans('user.activity.view.full.post'),
                            'route' => route('content.show', [$item->content->type, $item->content, '#comment-' . $item->id])
                        ]
                    ]
                ]
            ];

        }
    })
])
