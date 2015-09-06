@foreach ($items as $item)
    
    <div class="utils-border-bottom">

    @if ($item->type == 'photo')

        <div class="utils-padding-bottom">

        @include('component.card', [
            'image' => $item->image('large'),
            'options' => '-noshade -wide'
        ])

        </div>

    @endif


    @if ($item->activity_type == 'content') 

        @include('component.row', [
            'image' => $user->preset('xsmall_square'),
            'text' => trans('user.activity.index.row.content', [
                'user' => $user->name,
                'title' => '<a href="'
                    . route('content.show', [$item->type, $item->id])
                    . '">'
                    . $item->title
                    . '</a>',
                'created_at' => $item->created_at->diffForHumans()
            ])
        ])

    @else

        @include('component.row', [
            'image' => $user->preset('xsmall_square'),
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
                'created_at' => $item->created_at->diffForHumans()
            ])
        ])

    @endif

    </div>

@endforeach