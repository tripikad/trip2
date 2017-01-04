@php

$facts = collect($facts) ?? collect();

@endphp

<div class="DestinationFacts {{ $isclasses }}">

    <table>

        <tbody>

        @foreach ($facts as $key => $value)

        <tr>
            
            <td class="DestinationFacts__key">{{ $key }}</td>
            
            <td class="DestinationFacts__value">{{ $value }}</td>
        
        </tr>

        @endforeach

        </tbody>

    </table>

</div>
