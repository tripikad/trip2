@php

$items = $items ?? [];
$cols = $cols ?? 3;
$gapclass = isset($gap) ? 'Grid--gap'.$gap : '';
$widths = isset($widths) ? preg_split('/\s+/', $widths) : array_fill(0, $cols, 1);

@endphp

<div class="Grid {{ $isclasses }} {!! $gapclass !!} ">

    @foreach (collect($items)->chunk($cols) as $row)

        <div class="Grid__row">

            @foreach ($row->values() as $colIndex => $item)

                <div class="Grid__item" style="flex: {{ $widths[$colIndex] }}">

                    {!! $item !!}

                </div>
            
            @endforeach

        </div>

    @endforeach

</div>
