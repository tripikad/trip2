<div class="FlightNewsletterSubscribe {{ $isclasses }}">
    <div class="margin-bottom-md">
        <div class="BlockTitle__title">{!! trans('newsletter.subscribe.flight.heading') !!}</div>
    </div>

    {!! $form !!}

    @if ($info)
        <div class="margin-top-md">
            <p class="Body FlightNewsletterSubscribe__info">{!! $info !!}</p>
        </div>
    @endif
</div>