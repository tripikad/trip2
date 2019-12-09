@php

$tag = $tag ?? 'section';
$title = isset($title) ? $title : '';
$margin_bottom = isset($gap) ? spacer($gap) : '';
$padding = isset($padding) ? spacer($padding) : '';
$width_value = isset($width) ? $width : styles('desktop-width');
$align = $align ?? 'stretch';
$valign = $valign ?? 'stretch';
$background_color = isset($background) ? styles($background) : '';

$height_value = 'auto';
if (isset($height) && is_numeric($height)) {
$height_value = spacer($height);
}
else if (isset($height) && !is_numeric($height)) {
$height_value = $height;
}

$background_image = '';
if (isset($tint) && $tint && isset($image)) {
$background_image = 'linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.4)), url('.$image.')';
}
if ((!isset($tint) || !$tint) && isset($image)) {
$background_image = 'url('.$image.')';
}

$items_collection = items($items);

@endphp

<{{ $tag }} class="Container {{ $isclasses }}" style="
        border: 3px solid red;
        padding: {{ $padding }} {{ spacer() }}; 
        align-items: {{ $valign }};
        min-height: {{ $height_value }};
        background: {{ $background_color }};
        background-image: {{ $background_image }};">

    <div class="Container__items" style="border: 3px solid green; align-items: {{ $align }}; width: {{ $width_value }}">

        @foreach ($items_collection as $item)

        <div class="Container__item"
            style="border: 3px solid blue; marginBottom: {{ $loop->last ? '' : $margin_bottom }}">

            {!! $item !!}

        </div>

        @endforeach

    </div>

</{{ $tag }}>