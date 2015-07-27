<div class="component-flag">

    <div class="good">

        @include('components.number', [
            'number' => $good,
            'options' => '-good' . (! $good ? ' -empty' : '')
        ])

    </div>

    <div class="bad">

        @include('components.number', [
            'number' => $bad,
            'options' => '-bad' . (! $bad ? ' -empty' : '')
        ])

    </div>

</div>