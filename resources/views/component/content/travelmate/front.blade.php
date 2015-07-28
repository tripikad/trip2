<div class="row">

    @foreach ($contents as $content)

        <div class="col-xs-6 col-sm-3 utils-padding-bottom">

            <a href="{{ route('content.show', [$content->type, $content]) }}">

                @include('component.card', [
                    'image' => $content->user->imagePathOnly(),
                    'title' => $content->title,
                    'options' => '-square -center'

                ])

            </a>

        </div>

    @endforeach

</div>