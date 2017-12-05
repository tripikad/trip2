@php

$items = collect($items) ?? collect();
$cols = $cols ?? 'repeat('.$items->count().', 1fr)';
$gap = isset($gap) ? 'calc('.$gap.' * 12px)' : '0';

@endphp

<div
    class="ExperimentGrid {{ $isclasses }}"
    style="
        grid-template-columns: {{ $cols }};
        grid-gap: {{ $gap }}
    "
>
    
    @foreach ($items as $item)

        <div class="ExperimentGrid__item">

            {!! $item !!}

        </div>

    @endforeach

</div>
