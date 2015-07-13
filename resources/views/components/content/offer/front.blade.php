<div class="row">

    @foreach ($contents as $content)

        <div class="col-xs-6 col-sm-3">

            <a href="{{ route('content.show', [$content->type, $content]) }}">

                @include('components.card', [
                    'image' => $content->imagePath(),
                    'title' => $content->title,
                ])
                    
            </a>

        </div>

    @endforeach

</div>