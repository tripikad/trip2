@php

$items = $items ?? [];

$align = $align ?? '';
$valign = $align ?? 'flex-start';
$wrap_class = isset($wrap) ? 'Flex--wrap' : '';
$responsive_class = isset($responsive) && !$responsive ? '' : 'Flex--responsive';
$gap_value = isset($gap) ? spacer($gap) : spacer(1);
$overflow = isset($scroll) ? 'auto' : 'none';

@endphp

<div class="Flex {{ $isclasses }} {{ $wrap_class }} {{ $responsive_class }}" style="
    justify-content: {{ $align }};
    align-items: {{ $valign }};
    overflow: {{ $overflow }};
    --gap: {{ $gap_value }};
  ">

  @foreach ($items as $item)

  {!! $item !!}

  @endforeach

</div>