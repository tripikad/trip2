@php

$items = $items ?? [];

$justify = $justify ?? '';
$align = $align ?? 'flex-start';
$wrap_class = isset($wrap) ? 'Flex--wrap' : '';
$responsive_class = isset($responsive) && !$responsive ? '' : 'Flex--responsive';
$gap_value = isset($gap) ? spacer($gap) : spacer(1);
$overflow = isset($scroll) ? 'auto' : 'none';

@endphp

<div class="Flex {{ $isclasses }} {{ $wrap_class }} {{ $responsive_class }}" style="
    justify-content: {{ $justify }};
    align-items: {{ $align }};
    overflow: {{ $overflow }};
    --gap: {{ $gap_value }};
  ">

  @foreach ($items as $item)

  {!! $item !!}

  @endforeach

</div>