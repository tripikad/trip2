<div class="component-flag">

    <div class="good">
        <a href="">
        @include('components.circle', [
            'number' => $flags['good'],
            'options' => '-good' . (! $flags['good'] ? ' -empty' : '')
        ])
        </a>
    </div>

    <div class="bad">

        @include('components.circle', [
            'number' => $flags['bad'],
            'options' => '-bad' . (! $flags['bad'] ? ' -empty' : '')
        ])

    </div>

</div>