<div class="row">

    @foreach($users as $index => $flag)

        <div class="col-xs-2 utils-padding-bottom">

            <a href="{{ route('user.show', [$flag->user]) }}">
                
                @include('component.image', [
                    'image' => $flag->user->imagePath(),
                    'options' => '-circle'
                ])
            
            </a>

        </div>
        
        @if (($index + 1) % 6 == 0) </div><div class="row"> @endif

    @endforeach

</div>