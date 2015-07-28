<div class="row">

    @foreach ($contents as $index => $content)

        <div class="col-sm-4">

            <div class="row">

                <div class="col-xs-2">
                    
                    <a href="{{ route('user.show', [$content->user]) }}">
                        @include('component.image', [
                            'image' => $content->user->imagePath(),
                            'options' => '-circle'
                        ])
                    </a>
                
                </div>
                
                <div class="col-xs-10">
                    
                    <h4>
                        <a href="{{ route('content.show', [$content->type, $content]) }}">{{ $content->title }}
                        </a>
                    </h4>
                    
                    <p>{{ trans("content.$type.front.row.text", ['user' => $content->user->name]) }}</p>
                
                </div>

            </div>

        </div>

        @if (($index + 1) % 3 == 0) </div><div class="row"> @endif

    @endforeach

</div>