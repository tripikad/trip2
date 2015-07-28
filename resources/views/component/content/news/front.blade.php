<div class="row">

    @foreach ($contents as $content)

        <div class="col-sm-4 utils-padding-bottom">

            <a href="{{ route('content.show', [$content->type, $content]) }}">

                @include('component.card', [
                    'image' => $content->imagePath(),
                    'title' => $content->title,
                ])

            </a>

        </div>

    @endforeach

</div>