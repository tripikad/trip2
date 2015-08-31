@if (count($contents) > 0)

<h3 class="utils-padding-bottom">{{ trans('frontpage.index.flight.title') }}</h3>

<div class="row utils-double-padding-bottom">

    @foreach ($contents as $content)

        <div class="col-xs-6 col-sm-3 utils-padding-bottom">

            <a href="{{ route('content.show', [$content->type, $content]) }}">

                @include('component.card', [
                    'text' => $content->title,
                    'options' => '-center -yellow'
                ])
                    
            </a>

        </div>

    @endforeach

</div>

@endif