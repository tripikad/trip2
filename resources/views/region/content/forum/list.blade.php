@if (isset($items) && count($items))
    @if (!isset($modifiers) && $modifiers = []) @endif
    @include('component.content.forum.list', [
        'modifiers' => (isset($modifiers) && isset($modifiers['main']) ? $modifiers['main'] : null),
        'items' => $items->transform(function ($item) use ($modifiers) {
            return [
                'topic' => str_limit($item->title, 50),
                'route' => route($item->type.'.show', [$item->slug]),
                'date' => view('component.date.relative', [
                    'date' => $item->updated_at
                ]),
                'profile' => [
                    'modifiers' => (isset($modifiers) && isset($modifiers['profile']) ? $modifiers['profile'] : 'm-mini'),
                    'image' => $item->user->imagePreset(),
                    'letter' => [
                        'modifiers' => (isset($modifiers) && isset($modifiers['letter']) ? $modifiers['letter'] : 'm-green m-small'),
                        'text' => (strlen($item->user->name) ? $item->user->name[0] : '')
                    ],
                ],
                'badge' => [
                    'modifiers' => (isset($modifiers) && isset($modifiers['badge']) ? $modifiers['badge'] : 'm-inverted'),
                    'count' => count($item->comments)
                ],
                'tags' => (isset($modifiers) && isset($modifiers['main']) && strstr($modifiers['main'], 'm-compact') ? null :
                    $item->topics->take((isset($tags) && isset($tags['take']) ? $tags['take'] : 2))->transform(function ($topic) use ($item) {
                        return [
                            'title' => $topic->name,
                            'modifiers' => 'm-gray',
                            'route' => route($item->type.'.index').'?topic='.$topic->id,
                        ];
                    })
                )
            ];
        })
    ])

@endif
