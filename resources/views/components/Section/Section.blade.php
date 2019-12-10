@php

$tag = $tag ?? 'section';
$title = isset($title) ? $title : '';
$gap_value = isset($gap) ? spacer($gap) : '0';
$padding = isset($padding) ? spacer($padding) : '0';
$inner_padding = isset($inner_padding) ? spacer($inner_padding) : '0';
$width_value = isset($width) ? $width : styles('desktop-width');
$align = $align ?? 'stretch';
$valign = $valign ?? 'stretch';
$background_color = isset($background) ? styles($background) : '';
$inner_background_color = isset($inner_background) ? styles($inner_background) : '';
$border = isset($debug) ? '1px dashed ' . styles('red') : 'none';
$opacity = isset($dimmed) && $dimmed ? styles('opacity-md') : 1;

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

$items_collection = items($items ?? null);

@endphp

<{{ $tag }} class="Section {{ $isclasses }}" style="
        padding: {{ $padding }} {{ spacer(2) }}; 
        align-items: {{ $valign }};
        min-height: {{ $height_value }};
        background: {{ $background_color }};
        background-image: {{ $background_image }};
        border: {{ $border }};
">

    <div class="Section__items" style="
        --gap: {{ $gap_value }};
        padding: {{ $inner_padding }}; 
        align-items: {{ $align }};
        width: {{ $width_value }};
        background: {{ $inner_background_color }};
        opacity: {{ $opacity }};
    ">

        @foreach ($items_collection as $item)

        {!! $item !!}

        @endforeach

    </div>

</{{ $tag }}>