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
                    'text' =>  $content->user->name[0]
                ],
                'status' => [
                    'modifiers' => 'm-blue',
                    'position' => $comment->user->rank,
                    'editor' => $comment->user->role == 'admin'?true:false
                ],
            ],
            'date' => view('component.date.relative', ['date' => $comment->created_at]),
            'text' => nl2br($comment->body_filtered),
            'actions' => view('component.actions', ['actions' => $comment->getActions()]),
            'thumbs' => view('component.flags', ['flags' => $comment->getFlags()]),
        ])

    @endforeach

@endif
