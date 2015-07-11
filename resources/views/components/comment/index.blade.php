@if (count($comments))

@foreach ($comments as $comment)

    <div id="comment-{{ $comment->id }}">

        @include('components.row', [
            'image' => $comment->user->imagePath(),
            'image_link' => '/user/' . $comment->user->id,
            'heading' => null,
            'text' => 'By <a href="/user/' . $comment->user->id .'">'
            . $comment->user->name
            . '</a>'
        ])

        <div class="row">

            <div class="col-sm-1">      
            </div>

            <div class="col-sm-10">

                {!! nl2br($comment->body) !!}

            </div>

            <div class="col-sm-1"> 
                <a href="/comment/{{ $comment->id}}/edit">Edit</a> 
            </div>

        </div>

    </div>
    
    <hr />

@endforeach

@endif
