@foreach ($items as $item)
    
    <div class="utils-padding-bottom">

    @if ($item->activity_type == 'content') 

        @include('component.row', [
            'image' => $user->imagePreset(),
            'description' => trans('user.activity.index.row.content', [
                'user' => $user->name,
                'title' => '<a href="'
                    . route('content.show', [$item->type, $item->id])
                    . '">'
                    . $item->title
                    . '</a>',
                'created_at' => view('component.date.relative', ['date' => $item->created_at])
            ]),
            'options' => '-narrow -small'
        ])

    @else

        @include('component.row', [
            'image' => $user->imagePreset(),
            'description' => trans('user.activity.index.row.comment', [
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
            'options' => '-small -narrow'
        ])

    @endif

    </div>

@endforeach