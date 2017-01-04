@include('component.inline_list', [
    'modifiers' => 'm-light m-small',
    'items' => [
        [
            'title' => $comment->user->name,
            'route' => ($comment->user->name != 'Tripi külastaja' ? route('user.show', [$comment->user]) : false)
        ],
        [
            'title' => view('component.date.relative', ['date' => $comment->created_at]),
            'route' => '#comment-{{ $comment->id }}" alt="{{ $comment->created_at }}'
        ],
    ]
])
