@if (count($comments))

    @foreach ($comments as $index => $comment)


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
