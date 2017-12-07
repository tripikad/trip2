@php

$items = collect($items) ?? collect();
$cols = $cols ?? 3;

@endphp

<div class="Grid {{ $isclasses }}">

    @foreach ($items->chunk($cols) as $row)

        <div class="Grid__row">

            @foreach ($row as $item)

                <div class="Grid__item">

                    {!! $item !!}

                </div>
            
            @endforeach

        </div>

    @endforeach

</div>
