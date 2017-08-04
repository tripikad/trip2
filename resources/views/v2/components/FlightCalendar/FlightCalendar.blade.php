@php

$months = $months ?? [];

@endphp

<div class="FlightCalendar {{ $isclasses }}">

    @foreach($months as $month => $dates)

    <div class="FlightCalendar__month">

        <div class="FlightCalendar__monthTitle">
        
        {{ $month }}

        </div>


        @foreach($dates as $date)
            
            <div class="FlightCalendar__card">

                {!! $date !!}

            </div>

        @endforeach

    </div>

    @endforeach

</div>
