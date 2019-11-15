@php

$icon = $icon ?? '';
$size = $size ?? 'md';
$size_map = ['sm' => 14, 'md' => 18, 'lg' => 26, 'xl' => 36 ];

@endphp

<svg class="Icon {{ $isclasses }}" width="{{ $width ?? $size_map[$size] }}" height="{{ $height ?? $size_map[$size] }}">

  <use xlink:href="#{{ $icon }}"></use>

</svg>