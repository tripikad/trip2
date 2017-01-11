@if (count($comments))

    @foreach ($comments as $index => $comment)
        <a id="comment-{{ $comment->id }}" name="comment-{{ $comment->id }}"></a>
        @include('component.content.forum.post', [
            'modifiers' => (! $comment->status ? 'm-unpublished' : ''),
            'profile' => [
                'modifiers' => 'm-full m-status',
                'image' => $comment->user->imagePreset('xsmall_square'),
                'title' => $comment->user->name,
                'route' => ($comment->user->name != 'Tripi külastaja' ? route('user.show', [$comment->user]) : false),
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
