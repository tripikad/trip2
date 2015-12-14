@if (count($comments))

    @foreach ($comments as $index => $comment)

        {{--

        @include('component.row', [
            'profile' => [
                'modifiers' => 'm-small',
                'image' => $comment->user->imagePreset('xsmall_square'),
                'route' => route('user.show', [$comment->user])
            ],
            'text' => view('component.comment.text', ['comment' => $comment]),
            'actions' => view('component.actions', ['actions' => $comment->getActions()]),
            'extra' => view('component.flags', ['flags' => $comment->getFlags()]),
            'body' => nl2br($comment->body_filtered),
            'modifiers' => 'm-image m-quote'
        ])

        --}}

        @include('component.content.forum.post', [
            'profile' => [
                'modifiers' => 'm-full m-status',
                'image' => $comment->user->imagePreset('xsmall_square'),
                'title' => $comment->user->name,
                'route' => route('user.show', [$comment->user])
            ],
            'date' => view('component.date.relative', ['date' => $comment->created_at]),
            'text' => nl2br($comment->body_filtered),
            'thumbs' => view('component.flags', ['flags' => $comment->getFlags()]),
        ])

    @endforeach

@endif
