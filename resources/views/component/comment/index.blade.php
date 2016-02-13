@if (count($comments))

    @foreach ($comments as $index => $comment)

        @include('component.content.forum.post', [
            'profile' => [
                'modifiers' => 'm-full m-status',
                'image' => $comment->user->imagePreset('xsmall_square'),
                'title' => $comment->user->name,
                'route' => route('user.show', [$comment->user]),
                'letter' => [
                    'modifiers' => 'm-blue m-small',
                    'text' => 'J'
                ],
                'status' => [
                    'modifiers' => 'm-blue',
                    'position' => '1'
                ]
            ],
            'date' => view('component.date.relative', ['date' => $comment->created_at]),
            'text' => nl2br($comment->body_filtered),
            'actions' => view('component.actions', ['actions' => $comment->getActions()]),
            'thumbs' => view('component.flags', ['flags' => $comment->getFlags()]),
        ])

    @endforeach

@endif
