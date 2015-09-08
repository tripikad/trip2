<div class="component-flag">

    <div class="good">

        @if ($flags['good']['flaggable'])
        
            <a href="{{ route('flag.toggle', [
                $flags['good']['flaggable_type'],
                $flags['good']['flaggable_id'],
                $flags['good']['flag_type'],
                isset($flags['good']['return']) ? $flags['good']['return'] : null,
            ]) }}">
        
        @endif 

        @include('component.circle', [
            'number' => $flags['good']['value'],
            'options' => '-good' . (! $flags['good']['value'] ? ' -empty' : '')
        ])

        @if ($flags['good']['flaggable'])

            </a>

        @endif 

    </div>

    <div class="bad">

        @if ($flags['bad']['flaggable'])

            <a href="{{ route('flag.toggle', [
                $flags['bad']['flaggable_type'],
                $flags['bad']['flaggable_id'],
                $flags['bad']['flag_type'],
                isset($flags['bad']['return']) ? $flags['bad']['return'] : null,
            ]) }}">

        @endif

        @include('component.circle', [
            'number' => $flags['bad']['value'],
            'options' => '-bad' . (! $flags['bad']['value'] ? ' -empty' : '')
        ])

        @if ($flags['bad']['flaggable'])

            </a>

        @endif

    </div>

</div>