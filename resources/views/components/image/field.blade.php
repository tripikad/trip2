<div class="well" style="
    width: 100%;
    height: 100px;
    display: flex;
    justify-content: center;
    align-items: center;

    @if (isset($image))
 
        background-position: center;
        background-size: cover;
        background-image: url({{ $image }});
 
    @endif

">

<a
    href=""
    id="image_link"
    class="btn btn-default"
    data-selected-title="{{ trans('content.field.image.selected.title') }}"
>

    {{ trans('content.field.image.title') }}

</a>

</div>