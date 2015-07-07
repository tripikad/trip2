<div class="row">

    @foreach ($contents as $content)

        <div class="col-sm-4">

            <a href="/content/{{ $content->id }}">

                @include('components.card', [
                    'image' => $content->imagePath(),
                    'title' => $content->title,
                ])

            </a>

        </div>

    @endforeach

</div>