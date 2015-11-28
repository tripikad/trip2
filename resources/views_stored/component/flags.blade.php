<div class="c-flag">

    <div class="c-flag__item m-green">

        <div class="c-flag__item-text">

            @if ($flags['good']['flaggable'])

                <a href="{{ route('flag.toggle', [
                    $flags['good']['flaggable_type'],
                    $flags['good']['flaggable_id'],
                    $flags['good']['flag_type'],
                    isset($flags['good']['return']) ? $flags['good']['return'] : null,
                ]) }}" class="c-flag__item-link">

            @endif

            {{ $flags['good']['value'] }}

            @if ($flags['good']['flaggable'])

                </a>

            @endif

        </div>

    </div>

    <div class="c-flag__item m-red">

        <div class="c-flag__item-text">

            @if ($flags['bad']['flaggable'])

                <a href="{{ route('flag.toggle', [
                    $flags['bad']['flaggable_type'],
                    $flags['bad']['flaggable_id'],
                    $flags['bad']['flag_type'],
                    isset($flags['bad']['return']) ? $flags['bad']['return'] : null,
                ]) }}" class="c-flag__item-link">

            @endif

            {{ $flags['bad']['value'] }}

            @if ($flags['bad']['flaggable'])

                </a>

            @endif

        </div>

    </div>

</div>
