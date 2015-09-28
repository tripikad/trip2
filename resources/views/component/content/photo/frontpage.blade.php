@if (count($contents) > 0)

<h3 class="utils-padding-bottom">{{ trans('frontpage.index.photo.title') }}</h3>

<div class="row utils-padding-bottom">

    @foreach ($contents as $content)

        <div class="col-sm-4">
       
            <a href="{{ route('content.show', [$content->type, $content]) }}">
            
                @include('component.card', [
                    'image' => $content->imagePreset(),
                    'options' => '-noshade'
                ])
        
            </a>

        </div>

    @endforeach

</div>

@endif