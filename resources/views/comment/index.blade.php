@foreach ($comments as $comment)
  
  <h3>{{ $comment->title }} @include('user.item', ['user' => $comment->user])</h3>

  <p><small>@include('flag.show', ['flags' => $comment->flags])</small></p>

  {!! nl2br($comment->body) !!}


@endforeach

