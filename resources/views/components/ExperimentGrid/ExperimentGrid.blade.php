@php

$items = collect($items) ?? collect();
$rows = $rows ?? 'repeat('.$items->count().', 1fr)';
$gap = isset($gap) ? 'calc('.$gap.' * 12px)' : '0';

@endphp

<div
    class="ExperimentGrid {{ $isclasses }}"
    style="
        grid-template-columns: {{ $rows }};
        grid-gap: {{ $gap }}
    "
>
    
    @foreach ($items as $item)

        <div class="Grid__item">

            {!! $item !!}

        </div>

    @endforeach

</div>
