<div class="row">

    @foreach ($contents as $index => $content)

        <div class="col-sm-6">

            <div class="row">

                <div class="col-xs-2">
                    
                    <a href="{{ route('user.show', [$content->user]) }}">
                        
                        @include('components.image.circle', ['image' => $content->user->imagePath()])
                    
                    </a>
                
                </div>
                
                <div class="col-xs-10">
                    
                    <h3>
                        <a href="{{ route('content.show', [$content->type, $content]) }}">{{ $content->title }}
                        </a>
                    </h3>
                    
                    <p>{{ trans("content.$type.front.row.text", ['user' => $content->user->name]) }}</p>
                
                </div>

            </div>

        </div>

        @if (($index + 1) % 2 == 0) </div><div class="row"> @endif

    @endforeach

</div>