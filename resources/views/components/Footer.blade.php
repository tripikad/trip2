<div {{ $attributes->merge(['class' => 'Footer Footer--' . $type]) }}>
    <div class="container">
        <div class="Footer__wrapper">
            <div class="Footer__col">
                <a href="{{ route('frontpage.index') }}">
                    <svg class="Footer__tripLogo">
                        <use xlink:href="#tripee_logo_plain"></use>
                    </svg>
                </a>
            </div>

            @foreach(['col1', 'col2', 'col3'] as $col)

                <div class="Footer__col">

                    @foreach($links[$col] as $link)

                        <a href="{{ $link['route'] }}">
                            <div class="Footer__link">{{ $link['title'] }}</div>
                        </a>

                    @endforeach

                </div>

            @endforeach

        </div>

        <div class="Footer__social">

            @foreach($links['social'] as $link)

                <a href="{{ $link['route'] }}" target="_blank">
                    <span class="Footer__socialIcon">
                        <svg>
                            <use xlink:href="#{{ $link['icon'] }}"></use>
                        </svg>
                    </span>
                    <span class="Footer__socialLink">{{ $link['title'] }}</span>
                </a>

            @endforeach

        </div>

        <div class="Footer__licence">

            {{ trans('site.footer.copyright', [
                'current_year' => \Carbon\Carbon::now()->year
            ])}}

        </div>

    </div>

</div>