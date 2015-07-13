<div class="row">

    @foreach ($contents as $content)

        <div class="col-xs-6 col-sm-3">

            <a href="{{ route('content.show', [$content->type, $content]) }}">

                @include('components.card', [
                    'title' => $content->title,
                    ])
                    
            </a>

        </div>

    @endforeach

</div>