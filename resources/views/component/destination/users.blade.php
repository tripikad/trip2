@foreach($users->chunk(12) as $chunk)

    <div class="row">

    @foreach($chunk as $user)

        <div class="col-xs-1 utils-padding-bottom utils-half-padding-right">

            <a @php if ($user->user->name != 'Tripi külastaja') { echo 'href="'.route('user.show', [$user->user]).'"'; } @endphp>
                
                @include('component.user.image', [
                    'image' => $user->user->imagePreset('xsmall_square'),
                    'modifiers' => 'm-circle'
                ])
            
            </a>

        </div>
        
    @endforeach

    </div>

@endforeach
