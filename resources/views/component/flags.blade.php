<div class="c-flag">

    <div class="c-flag__item m-green">

        @if ($flags['good']['flaggable'])

            <a href="{{ route('flag.toggle', [
                $flags['good']['flaggable_type'],
                $flags['good']['flaggable_id'],
                $flags['good']['flag_type'],
                isset($flags['good']['return']) ? $flags['good']['return'] : null,
            ]) }}" class="c-flag__item-link js-ajax_get">

        @endif

        <div class="c-flag__item-icon">

            @include('component.svg.sprite', [
                'name' => 'icon-thumb-up'
            ])

        </div>

        <div class="c-flag__item-text">

            {{ $flags['good']['value'] }}

        </div>

        @if ($flags['good']['flaggable'])

            </a>

        @endif

    </div>

    <div class="c-flag__item m-red">

        @if ($flags['bad']['flaggable'])

            <a href="{{ route('flag.toggle', [
                $flags['bad']['flaggable_type'],
                $flags['bad']['flaggable_id'],
                $flags['bad']['flag_type'],
                isset($flags['bad']['return']) ? $flags['bad']['return'] : null,
            ]) }}" class="c-flag__item-link js-ajax_get">

        @endif

        <div class="c-flag__item-icon">

            @include('component.svg.sprite', [
                'name' => 'icon-thumb-down'
            ])

        </div>

        <div class="c-flag__item-text">

            {{ $flags['bad']['value'] }}

        </div>

        @if ($flags['bad']['flaggable'])

            </a>

        @endif

    </div>

</div>
