@if (count($comments))

{{--
<hr />
<p class="text-center">

    Topic started at {{ $content->created_at->diffForHumans() }}, has {{ count($comments) }} comments, latest from {{ $comments[count($comments) - 1]->created_at->diffForHumans() }}

</p>
--}}

@foreach ($comments as $comment)
  
  <hr />

  <div class="row">

         <div class="col-xs-2 col-sm-1">
        
            <a href="/user/{{ $comment->user->id }}">
                @include('image.circle', ['image' => $comment->user->imagePath()])
            </a>
      
        </div>
      
        <div class="col-xs-9 col-sm-10">
      
            <p>
                By @include('user.item', ['user' => $comment->user])
                at {{ $comment->created_at->format('d. m Y') }}
            </p>

            {!! nl2br($comment->body) !!}
      
        </div>

        <div class="col-sm-1">

            <small>@include('flag.show', ['flags' => $comment->flags])</small>
  
        </div>
  </div>

@endforeach

@endif
