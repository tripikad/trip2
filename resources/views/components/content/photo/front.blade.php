<div class="row">

    @foreach ($contents as $content)

        <div class="col-sm-4">
       
            <a href="{{ route('content.show', [$content->type, $content]) }}">
            
                @include('components.image.landscape', [
                    'image' => $content->imagePath(),
                ])
        
            </a>

        </div>

    @endforeach

</div>