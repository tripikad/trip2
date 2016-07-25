@if (isset($items) && count($items))
    @include('component.travelmate.list', [
        'modifiers' => 'm-'.count($items).'col',
        'items' => $items->transform(function ($item) {
            return [
                'modifiers' => 'm-small',
                'image' => $item->user->imagePreset('small_square'),
                'letter' => [
                    'modifiers' => 'm-red',
                    'text' => (strlen($item->user->name) ? $item->user->name[0] : '')
                ],
                'name' => $item->user->name,
                'route' => route($item->type.'.show', [$item->slug]),
                'sex_and_age' =>
                    ($item->user->gender ?
                        trans('user.gender.'.$item->user->gender).
                            ($item->user->age ? ', ' : '')
                                : null).
                                    ($item->user->age ? $item->user->age : null),
                'title' => $item->title,
                'tags' => $item->destinations->take(0)->transform(function ($item_destination) {
                    return [
                        'modifiers' => ['m-purple', 'm-yellow', 'm-red', 'm-green'][rand(0,3)],
                        'title' => $item_destination->name
                    ];
                })
            ];
        })
    ])
@endif
