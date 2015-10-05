@if (count($contents) > 0)

@include('component.subheader', [
    'title' => trans('frontpage.index.flight.title'),
    'link_title' => '',
    'link_route' => '',
    'options' => '-padding -orange',
])

<div class="row utils-padding-bottom">

    @foreach ($contents as $content)

        <div class="col-sm-3">

            <a href="{{ route('content.show', [$content->type, $content]) }}">

                @include('component.card', [
                    'image' => $content->imagePreset(),
                    'title' => $content->price ? trans("content.flight.index.field.price", [
                        'price' => $content->price,
                        'symbol' => config('site.currency.symbol')
                    ]) : null,
                    'text' => $content->title,
                    'options' => '-center'
                ])
                    
            </a>

        </div>

    @endforeach

</div>

@endif