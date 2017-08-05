@php

$months = $months ?? [];

@endphp

<div class="FlightCalendar {{ $isclasses }}">

    @foreach($months as $month => $dates)

    <div class="FlightCalendar__month">

        <div class="FlightCalendar__monthTitle">
        
            {{ $month }}

        </div>

        <div class="FlightCalendar__cards">

        @foreach($dates as $date)
            
            <div class="FlightCalendar__card">

                {!! format_body($date) !!}

            </div>

        @endforeach

        </div>

    </div>

    @endforeach

</div>
