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
            'image' => $comment->user->imagePreset(),
            'image_width' => '80%',
            'image_link' => route('user.show', [$comment->user]),
            'text' => view('component.comment.text', ['comment' => $comment]),
            'actions' => view('component.actions', ['actions' => $comment->getActions()]),
            'extra' => view('component.flags', ['flags' => $comment->getFlags()])

        ])

        <div class="row">

            <div class="col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2">

                {!! nl2br($comment->body) !!}

            </div>

        </div>

    </div>
    
@endforeach

@endif
