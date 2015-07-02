<div class="row">

    @foreach ($contents as $content)

        <div class="col-sm-3">

            <a href="/content/{{ $content->id }}">

                @include('component.card', [
                    'image' => $content->imagePath(),
                    'title' => null,
                    'subtitle' => $content->title,
                ])
                    
            </a>

        </div>

    @endforeach

</div>