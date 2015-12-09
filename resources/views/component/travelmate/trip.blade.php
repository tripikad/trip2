<div class="c-travelmate-trip">

    <div class="c-travelmate-trip__body">
        @if(isset($trip_start))
        <p class="c-travelmate-trip__info">
            <strong>Reisi algus</strong><br>
            <span>{{$trip_start}}</span>
        </p>
        @endif
        @if(isset($trip_duration))
        <p class="c-travelmate-trip__info">
            <strong>Kui pikalt võiks reis kesta?</strong><br>
            <span>{{$trip_duration}}</span>
        </p>
        @endif
        @if(isset($trip_mate))
        <p class="c-travelmate-trip__info">
            <strong>Millist kaaslast soovid leida?</strong><br>
            <span>{{$trip_mate}}</span>
        </p>
        @endif
    </div>
</div>