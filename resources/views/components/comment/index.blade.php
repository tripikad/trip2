@if (count($comments))

@foreach ($comments as $comment)

    <div
        id="comment-{{ $comment->id }}"
        class="utils-border-bottom
        @if (! $comment->status)
            utils-unpublished
        @endif
    ">

        @include('components.row', [
            'image' => $comment->user->imagePath(),
            'image_link' => route('user.show', [$comment->user]),
            'text' => trans("comment.index.row.text", [
                'user' => view('components.user.link', ['user' => $comment->user]),
                'created_at' => $comment->created_at->format('d. m Y H:i:s'),
            ])
        ])

        <div class="row">

            <div class="col-sm-10 col-sm-offset-1">

                {!! nl2br($comment->body) !!}

            </div>

            <div class="col-sm-1">
                @if (\Auth::check() && \Auth::user()->hasRoleOrOwner('admin', $comment->user->id))
                    <a href="{{ route('comment.edit', [$comment->id]) }}">Edit</a>
                @endif
            </div>

        </div>

    </div>
    
@endforeach

@endif
