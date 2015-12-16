<div class="c-user-location" style="top: {{ $top }}%; left: {{ $left }}%;">

    <div class="c-user-location__icon">

        @include('component.svg.sprite', [
            'name' => 'icon-pin'
        ])

    </div>

    <div class="c-user-location__info">

        @include('component.tooltip', [
            'modifiers' => 'm-bottom m-inverted m-center m-one-line '. $modifiers,
            'text' => 'Asukoht '. $location
        ])
    </div>

</div>