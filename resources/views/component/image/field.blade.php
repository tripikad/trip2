<div class="component-imagefield"
    
    @if (isset($image))

        style="background-image: url({{ $image }});"
 
    @endif

>

    <a
        href=""
        id="image_link"
        class="btn btn-default"
        data-selected-title="{{ trans('content.field.image.selected.title') }}"
    >

    {{ trans('content.field.image.title') }}

    </a>

</div>