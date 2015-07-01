@if (count($messages))

@foreach ($messages as $message)
  
  <hr />

  <div class="row">
  
        <div class="col-xs-2 col-sm-1">
        
            <a href="/user/{{ $message->fromUser->id }}">
                @include('image.circle', ['image' => $message->fromUser->imagePath()])
            </a>
      
        </div>
      
        <div class="col-xs-10 col-sm-10">

            <h4>{{ $message->title }}</h4>
            <p>
                By @include('user.item', ['user' => $message->fromUser])
                at {{ $message->created_at->format('d. m Y H:i:s') }}
            </p>

            {!! nl2br($message->body) !!}
      
        </div>

        <div class="col-sm-1">
  
        </div>

  </div>

@endforeach

@endif
