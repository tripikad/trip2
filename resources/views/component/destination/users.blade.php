@foreach($users->chunk(16) as $chunk)

    <div class="row">

    @foreach($chunk as $user)

        <div class="col-xs-1 utils-padding-bottom">

            <div style="width: 80%">

                <a href="{{ route('user.show', [$user->user]) }}">
                    
                    @include('component.user.image', [
                        'image' => $user->user->imagePreset('xsmall_square'),
                        'options' => '-circle'
                    ])
                
                </a>

            </div>

        </div>
        
    @endforeach

    </div>

@endforeach