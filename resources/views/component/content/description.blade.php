@include('component.inline_list', [
    'items' => [
        [
            'title' => $content->user->name,
            'route' => route('user.show', [$content->user])
        ],
        [
            'title' => view('component.date.relative', ['date' => $content->created_at])
        ],
        [
            'title' => trans('content.row.text.comment', [
                                'updated_at' => view('component.date.relative', ['date' => $content->updated_at])
                            ])
        ],
        [
            'title' => $content->destinations->implode('name', '</li><li>')
        ],
        [
            'title' => $content->topics->implode('name', '</li><li>')
        ]
    ]
])

<ul class="component-content-description list-inline">

    <li>
    
        {!! view('component.user.link', ['user' => $content->user]) !!}

    </li>

    <li>

        {{ view('component.date.relative', ['date' => $content->created_at]) }}

    </li>

@if (count($content->comments))

    <li>

        {{ trans('content.row.text.comment', [
            'updated_at' => view('component.date.relative', ['date' => $content->updated_at])
        ]) }}
    
    <li>

@endif

@if (count($content->destinations))

    <li>

        {!! $content->destinations->implode('name', '</li><li>') !!}

    </li>

@endif

@if (count($content->topics))

    <li>

        {!! $content->topics->implode('name', '</li><li>') !!}

    </li>

@endif

</ul>
