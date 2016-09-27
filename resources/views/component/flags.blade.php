<div class="c-flag">

    <div class="c-flag__item m-green">

        @if ($flags['good']['flaggable'])

            <a href="{{ route('flag.toggle', [
                $flags['good']['flaggable_type'],
                $flags['good']['flaggable_id'],
                $flags['good']['flag_type'],
                isset($flags['good']['return']) ? $flags['good']['return'] : null,
            ]) }}" class="c-flag__item-link {{ isset($flags['good']['active']) && $flags['good']['active'] ? 'm-active' : '' }} js-flag">

        @endif

        <div class="c-flag__item-icon {{ isset($flags['good']['active']) && $flags['good']['active'] ? '' : 'm-active' }} js-icon">

            @include('component.svg.sprite', [
                'name' => 'icon-thumb-up'
            ])

        </div>

        <div class="c-flag__item-icon m-filled {{ isset($flags['good']['active']) && $flags['good']['active'] ? 'm-active' : '' }} js-icon-filled">

            @include('component.svg.sprite', [
                'name' => 'icon-thumb-up-filled'
            ])

        </div>

        <div class="c-flag__item-text js-flag-text">

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
            ]) }}" class="c-flag__item-link {{ isset($flags['bad']['active']) && $flags['bad']['active'] ? 'm-active' : '' }} js-flag">

        @endif

        <div class="c-flag__item-icon {{ isset($flags['bad']['active']) && $flags['bad']['active'] ? '' : 'm-active' }} js-icon">

            @include('component.svg.sprite', [
                'name' => 'icon-thumb-down'
            ])

        </div>

        <div class="c-flag__item-icon m-filled {{ isset($flags['bad']['active']) && $flags['bad']['active'] ? 'm-active' : '' }} js-icon-filled">

            @include('component.svg.sprite', [
                'name' => 'icon-thumb-down-filled'
            ])

        </div>

        <div class="c-flag__item-text js-flag-text">

            {{ $flags['bad']['value'] }}

        </div>

        @if ($flags['bad']['flaggable'])

            </a>

        @endif

    </div>

</div>
