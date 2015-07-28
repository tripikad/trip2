<div class="row">

    @foreach ($contents as $content)

        <div class="col-sm-4">
       
            <a href="{{ route('content.show', [$content->type, $content]) }}">
            
                @include('components.image', [
                    'image' => $content->imagePath(),
                    'options' => '-landscape'
                ])
        
            </a>

        </div>

    @endforeach

</div>