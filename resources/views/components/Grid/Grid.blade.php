@php

$items = collect($items) ?? collect();
$cols = $cols ?? 3;
//$gapclass = isset($gap) ? 'Grid--gap--'.$gap : '';
$widths = isset($widths) ? preg_split('/\s+/', $widths) : array_fill(0, $cols, 1);

@endphp


<div class="Grid {{ $isclasses }} ">

    @foreach ($items->chunk($cols) as $row)

        <div class="Grid__row">

            @foreach ($row as $key => $item)

                <div class="Grid__item" style="flex: 1">

                    {!! $item !!}

                </div>
            
            @endforeach

        </div>

    @endforeach

</div>
