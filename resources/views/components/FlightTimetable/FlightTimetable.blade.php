@php

$months = $months ?? [];

@endphp

<div class="FlightTimetable {{ $isclasses }}">

    @foreach($months as $month => $dates)

    <div class="FlightTimetable__month">

        <div class="FlightTimetable__monthTitle">
        
            {{ $month }}

        </div>

        <div class="FlightTimetable__cards">

        @foreach($dates as $date)
            
            <div class="FlightTimetable__card">

                {!! $date !!}

            </div>

        @endforeach

        </div>

    </div>

    @endforeach

</div>
