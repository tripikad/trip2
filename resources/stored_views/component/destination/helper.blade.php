<div class="c-destination-helper {{ $modifiers or '' }}">

    <div class="c-destination-helper__header">

        <h3 class="c-destination-helper__title">{{ $title }} <span class="c-destination-helper__subtitle">Sihtkoha abimees</span></h3>

    </div>

    <div class="c-destination-helper__content">

        @if(isset($items))

            @include('component.list',[
                'modifiers' => 'm-medium m-default',
                'items' => $items
            ])

        @endif

        <div class="c-destination-helper__actions">

            @include('component.link',[
                'modifiers' => 'm-icon m-right',
                'title' => 'Veel',
                'route' => '',
                'icon' => 'icon-arrow-right'
            ])

        </div>

    </div>

</div>