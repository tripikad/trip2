<div class="component-flag">

    <div class="good">

        @include('components.circle', [
            'number' => $good,
            'options' => '-good' . (! $good ? ' -empty' : '')
        ])

    </div>

    <div class="bad">

        @include('components.circle', [
            'number' => $bad,
            'options' => '-bad' . (! $bad ? ' -empty' : '')
        ])

    </div>

</div>