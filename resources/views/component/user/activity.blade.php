@foreach ($items as $item)
    
    <div class="utils-padding-bottom">

    @if ($item->activity_type == 'content') 

        @include('component.row', [
            'profile' => [
                'modifiers' => '',
                'image' => $user->imagePreset(),
                'route' => ''
            ],
            'text' => trans('user.activity.index.row.content', [
                'user' => $user->name,
                'title' => '<a href="'
                    . route('content.show', [$item->type, $item->id])
                    . '">'
                    . $item->title
                    . '</a>',
                'created_at' => view('component.date.relative', ['date' => $item->created_at])
            ]),
            'modifiers' => '-narrow -small'
        ])

    @else

        @include('component.row', [
            'profile' => [
                'modifiers' => '',
                'image' => $user->imagePreset(),
                'route' => ''
            ],
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
            'modifiers' => '-small -narrow'
        ])

    @endif

    </div>

@endforeach
