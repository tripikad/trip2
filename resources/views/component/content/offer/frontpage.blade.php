@if (count($contents) > 0)

<h3 class="utils-padding-bottom">{{ trans('frontpage.index.offer.title') }}</h3>

<div class="row utils-padding-bottom">

    @foreach ($contents as $content)

        <div class="col-xs-6 col-sm-3 utils-padding-bottom">

            <a href="{{ route('content.show', [$content->type, $content]) }}">

                @include('component.card', [
                    'image' => $content->imagePath(),
                    'text' => $content->title,
                    'options' => '-center'
                ])
                    
            </a>

        </div>

    @endforeach

</div>

@endif