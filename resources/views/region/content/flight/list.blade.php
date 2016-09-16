@if (isset($items) && count($items))
    @foreach ($items as $item)
        @include('component.row', [
            'icon' => 'icon-tickets',
            'modifiers' => 'm-icon',
            'title' => $item->title.' '.($item->price != 0 ? $item->price.config('site.currency.symbol') : ''),
            'route' => route($item->type.'.show', [$item->slug]),
            'list' => [
                (isset($item->destinations) && count($item->destinations) ?
                [
                    'title' => $item->destinations->implode(', ')
                ] : null),
                [
                    'title' => view('component.date.range', [
                        'from' => $item->start_at,
                        'to' => $item->end_at
                    ])
                ],
                [
                    'title' => view('component.date.relative', ['date' => $item->created_at])
                ]
            ]
        ])
    @endforeach
@endif
