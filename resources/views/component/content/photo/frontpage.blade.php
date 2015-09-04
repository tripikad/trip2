@if (count($contents) > 0)

<h3 class="utils-padding-bottom">{{ trans('frontpage.index.photo.title') }}</h3>

<div class="row utils-double-padding-bottom">

    @foreach ($contents as $content)

        <div class="col-sm-3 utils-padding-bottom">
       
            <a href="{{ route('content.show', [$content->type, $content]) }}">
            
                @include('component.card', [
                    'image' => $content->images()->first()->preset(),
                    'options' => '-noshade'
                ])
        
            </a>

        </div>

    @endforeach

</div>

@endif