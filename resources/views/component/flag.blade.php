<div class="component-flag">

    <div class="good">

        @include('component.circle', [
            'number' => $good,
            'options' => '-good' . (! $good ? ' -empty' : '')
        ])

    </div>

    <div class="bad">

        @include('component.circle', [
            'number' => $bad,
            'options' => '-bad' . (! $bad ? ' -empty' : '')
        ])

    </div>

</div>