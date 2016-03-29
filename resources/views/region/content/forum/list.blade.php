@if (isset($items) && count($items))

    @include('component.content.forum.list', [
        'items' => $items->transform(function ($item) {
            return [
                'topic' => str_limit($item->title, 50),
                'route' => route('content.show', [$item->type, $item]),
                'date' => view('component.date.relative', [
                    'date' => $item->created_at
                ]),
                'profile' => [
                    'modifiers' => 'm-mini',
                    'image' => $item->user->imagePreset(),
                    'letter' => [
                        'modifiers' => 'm-green m-small',
                        'text' => 'D'
                    ],
                ],
                'badge' => [
                    'modifiers' => 'm-inverted',
                    'count' => count($item->comments)
                ],
                'tags' => $item->topics->take((isset($tags['take']) ? $tags['take'] : 2))->transform(function ($topic) use ($item) {
                    return [
                        'title' => $topic->name,
                        'modifiers' => 'm-gray',
                        'route' => route('content.index', [$item->type]).'?topic='.$topic->id,
                    ];
                })
            ];
        })
    ])

@endif
