<div class="row">

    @foreach ($contents as $content)

        <div class="col-xs-6 col-sm-3">

            <a href="/content/{{ $content->id }}">

                @include('component.card', [
                    'image' => $content->user->imagePathOnly(),
                    'title' => $content->title,
                    'text' => $content->user->name,
                ])

            </a>

        </div>

    @endforeach

</div>