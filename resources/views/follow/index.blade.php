@if (count($follows))

@foreach ($follows as $follow)
  
  <hr />

  <div class="row">
  
        <div class="col-xs-2 col-sm-1">
        
            <a href="/user/{{ $follow->followable->user->id }}">
                
                @include('image.circle', ['image' => $follow->followable->user->imagePath()])
     
            </a>
      
        </div>
      
        <div class="col-xs-10 col-sm-10">

            <h4>{{ $follow->followable->title }}</h4>
     
            <p>
     
                By @include('user.item', ['user' => $follow->followable->user])
     
            </p>
      
        </div>

        <div class="col-sm-1">
  
        </div>

  </div>

@endforeach

@endif
