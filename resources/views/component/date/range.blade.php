@if (isset($from) && isset($to))

    @if (Date::parse($from)->format('F Y') !== Date::parse($to)->format('F Y'))

        @if (Date::parse($from)->format('Y') !== Date::parse($to)->format('Y'))
            {{ Date::parse($from)->format('F Y') }} - {{ Date::parse($to)->format('F Y') }}
        @else
            {{ Date::parse($from)->format('F Y') }} - {{ Date::parse($to)->format('F Y') }}
        @endif

    @else

        {{ Date::parse($to)->format('F Y') }}

    @endif

@endif
