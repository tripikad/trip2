@php

$items = $items ?? [];

$justify = $justify ?? 'flex-start';

$align = $align ?? 'flex-start';

$spacer = style_vars()->spacer;

$gap_map = ['sm' => 1, 'md' => 2, 'lg' => 3];

if (isset($gap) && is_string($gap) && $gap_map[$gap]) {
$gap_string = 'calc('. $gap_map[$gap] .' * '. $spacer .')';
} else if (isset($gap) && !is_string($gap)) {
$gap_string = 'calc('. $gap .' * '. $spacer .')';
} else {
$gap_string = 'calc('. $gap_map['md'] .' * '. $spacer .')';
}

@endphp

<div class="Row {{ $isclasses }}" style="justify-content: {{ $justify }}; align-items: {{ $align }}">

  @foreach ($items as $item)

  <div class="Row__item" style="marginRight: {{ $loop->last ? '' : $gap_string }}">

    {!! $item !!}

  </div>

  @endforeach

</div>