@if (count($comments))

@foreach ($comments as $comment)

    <div
        id="comment-{{ $comment->id }}"
        class="utils-border-bottom
        @if (! $comment->status)
            utils-unpublished
        @endif
    ">

        @include('component.row', [
            'image' => $comment->user->imagePath(),
            'image_width' => '70%',
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

            <div class="col-sm-10 col-sm-offset-1">

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

                        @if ($comment->status == 1)
                            
                            {{ trans('content.action.unpublish') }}
                        
                        @else
                        
                            {{ trans('content.action.publish') }}
                        
                        @endif

                    </a>

                @endif

            </div>

        </div>

    </div>
    
@endforeach

@endif
