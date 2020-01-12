@php

$items = $items ?? [];

@endphp

<table class="Table {{ $isclasses }}">

    <tr class="Table__row">

        @foreach (collect(collect($items)->first())->keys() as $key)

        <th class="Table__header">

            {!! $key !!}

        </th>

        @endforeach

    </tr>

    @foreach (collect($items) as $row)

    <tr class="Table__row">

        @foreach (collect($row)->values() as $value)

        <td class="Table__cell">

            {!! $value !!}

        </td>

        @endforeach

    </tr>

    @endforeach

</table>