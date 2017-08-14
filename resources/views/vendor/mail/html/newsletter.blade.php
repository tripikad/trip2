@component('mail::newsletter_layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ asset('mail/tripee_logo_dark.png') }}" width="200" height="96" class="img-logo">
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            @if (isset($unsubscribe_id))
                Uudiskirjast loobumiseks <a href="{{ $unsubscribe_id }}">vajuta siia</a><br /><br />
            @endif
            {{ trans('site.footer.copyright', ['current_year' =>  \Carbon\Carbon::now()->year]) }}
        @endcomponent
    @endslot
@endcomponent
