<div class="c-travelmate-user {{ $modifiers or 'm-yellow' }}">

    <div class="c-travelmate-user__header">

        <div class="c-travelmate-user__image">
            <img src="{{ $image }}" alt="">
        </div>

        <div class="c-travelmate-user__header-info">

            <h2 class="c-travelmate-user__title">
                {{ $name }}
                @if(isset($sex_and_age))
                <span>({{ $sex_and_age }})</span>
                @endif
            </h2>

            @if(isset($social_items))

            <div class="c-travelmate-user__social">

                <ul class="c-button-group">

                    @foreach($social_items as $social)

                    <li class="c-button-group__item">
                        @include('component.button',[
                            'modifiers' => 'm-icon m-small m-round',
                            'icon' => view('component.icon',['icon' => $social['icon']]),
                            'route' => $social['route'],
                            'target' => '_blank'
                        ])
                    </li>

                    @endforeach
                </ul>

            </div>

            @endif

        </div>
    </div>

    <div class="c-travelmate-user__body">
        <div class="c-body">
            {!! $description !!}
        </div>
    </div>

    <div class="c-travelmate-user__footer">
        @include('component.button', [
            'modifiers' => 'm-block m-secondary',
            'title' => 'Saada sõnum',
            'route' => '#'
        ])
    </div>
</div>