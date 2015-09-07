@if (count($comments))

@foreach ($comments as $index => $comment)

    <div
        id="comment-{{ $comment->id }}"
        class="
        @if (count($comments) == ($index + 1))
            utils-padding-bottom 
        @else
            utils-border-bottom
        @endif
        @if (! $comment->status)
            utils-unpublished
        @endif
    ">

        @include('component.row', [
            'image' => $comment->user->preset('xsmall_square'),
            'image_width' => '80%',
            'image_link' => route('user.show', [$comment->user]),
            'text' => trans("comment.index.row.text", [
                'user' => view('component.user.link', ['user' => $comment->user]),
                'created_at' => $comment->created_at->diffForHumans(),
            ]),
            'extra' => view('component.flag', [ 'flags' => [
                'good' => [
                    'value' => count($comment->flags->where('flag_type', 'good')),
                    'flaggable' => \Auth::check(),
                    'flaggable_type' => 'comment',
                    'flaggable_id' => $comment->id,
                    'flag_type' => 'good',
                    'return' => '#comment-' . $comment->id
                ],
                'bad' => [
                    'value' => count($comment->flags->where('flag_type', 'bad')),
                    'flaggable' => \Auth::check(),
                    'flaggable_type' => 'comment',
                    'flaggable_id' => $comment->id,
                    'flag_type' => 'bad',
                    'return' => '#comment-' . $comment->id
                ]
            ]])
        ])

        <div class="row">

            <div class="col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2">

                {!! nl2br($comment->body) !!}

            </div>

            <div class="col-sm-1">
                
                @if (\Auth::check() && \Auth::user()->hasRoleOrOwner('admin', $comment->user->id))
                    
                    <a href="{{ route('comment.edit', [$comment->id]) }}">Edit</a>
                
                @endif
            
                @if (\Auth::check() && \Auth::user()->hasRole('admin'))
                    
                    <a href="{{ route('comment.status', [
                        $comment,
                        (1 - $comment->status)
                    ]) }}">
                    
                        {{ trans('content.action.' . config("site.statuses.$comment->status") . '.title') }}

                    </a>

                @endif

            </div>

        </div>

    </div>
    
@endforeach

@endif
