@if (count($contents) > 0)

@include('component.subheader', [
    'title' => trans('frontpage.index.shortnews.title'),
    'link_title' => '',
    'link_route' => '',
    'options' => '-padding -orange',
])

<div class="row utils-padding-bottom">

    @foreach ($contents as $content)

        <div class="col-sm-3 utils-padding-bottom">

            <a href="{{ route('content.show', [$content->type, $content]) }}">

                @include('component.card', [
                    'text' => $content->title,
                    'options' => ''
                ])
                    
            </a>

        </div>

    @endforeach

</div>

@endif