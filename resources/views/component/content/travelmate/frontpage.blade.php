@if (count($contents) > 0)

<h3 class="utils-padding-bottom">{{ trans('frontpage.index.travelmate.title') }}</h3>

<div class="row utils-padding-bottom">

    @foreach ($contents as $content)

        <div class="col-sm-3">

            <a href="{{ route('content.show', [$content->type, $content]) }}">

                @include('component.card', [
                    'image' => $content->user->imagePreset(),
                    'text' => $content->title,
                    'options' => '-center'

                ])

            </a>

        </div>

    @endforeach

</div>

@endif