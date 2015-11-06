@foreach ($items as $item)

    <div class="utils-padding-bottom {{ $item->activity_type }}">

    @if ($item->activity_type == 'content')

        @include('component.row', [
            'profile' => [
                'modifiers' => '',
                'image' => $user->imagePreset(),
                'route' => ''
            ],
            'modifiers' => 'm-image',
            'text' => trans('user.activity.index.row.content', [
                'user' => $user->name,
                'title' => '<a href="'
                    . route('content.show', [$item->type, $item->id])
                    . '">'
                    . $item->title
                    . '</a>',
                'created_at' => view('component.date.relative', ['date' => $item->created_at])
            ]),
        ])

    @else

        @include('component.row', [
            'profile' => [
                'modifiers' => '',
                'image' => $user->imagePreset(),
                'route' => ''
            ],
            'modifiers' => 'm-image',
            'text' => trans('user.activity.index.row.comment', [
                'user' => $user->name,
                'title' => '<a href="'
                    . route('content.show', [$item->content->type, $item->content->id])
                    . '">'
                    . $item->content->title
                    . '</a>',
                'comment_title' => '<a href="'
                    . route('content.show', [$item->content->type, $item->content->id, '#comment-' . $item->id])
                    . '">'
                    . $item->title
                    . '</a>',
                'created_at' => view('component.date.relative', ['date' => $item->created_at])
            ]),
        ])

    @endif

    </div>

@endforeach
