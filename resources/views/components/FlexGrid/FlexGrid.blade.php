@php

$items = $items ?? [];
$cols = $cols ?? 2;
$widths = isset($widths) ? preg_split('/\s+/', preg_replace('/[^0-9\s]/','',$widths)) : array_fill(0, $cols, 1);
$border = isset($debug) && $debug ? '1px dashed ' . styles('red') : 'none';
$gap_value = isset($gap) ? spacer($gap) : '0';
@endphp

<div class="FlexGrid {{ $isclasses }}">

    @foreach (collect($items)->chunk($cols) as $row)

        <div class="FlexGrid__row">

            @foreach ($row->values() as $colIndex => $item)

                <div class="FlexGrid__item" style="
                    flex: {{ $widths[$colIndex] }};
                    border: {{ $border }};
                    --gap: {{ $gap_value }}
                ">

                @foreach (items($item) as $collection_item)

                    <div>

                    {!! $collection_item !!}

                    </div>  
                    
                @endforeach

                </div>
            
            @endforeach

        </div>

    @endforeach

</div>
