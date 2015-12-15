{{--

title: Destination extra

code: |

    @include('component.destination.extra', [
        'items' => [
            [
                'icon' => 'icon-pin',
                'title' => '123',
                'text' => 'Postitusi foorumis',
                'route' => ''
            ],
            [
                'icon' => 'icon-offer',
                'title' => '421',
                'text' => 'Külastatud sihtkohti',
                'route' => ''
            ],
        ]
    ])

--}}

{{--

@if (\Auth::user())

    <ul class="c-button-group">

        <li class="c-button-group__item m-green">

            @include('component.button',[
                'modifiers' => 'm-small',
                'title' => (count($destination->usersHaveBeen()->where('user_id', \Auth::user()->id))
                    ?
                        trans('destination.show.user.button.havenotbeen')
                    :
                        trans('destination.show.user.button.havebeen')
                ),
                'route' => route('flag.toggle', ['destination', $destination, 'havebeen'])
            ])

        </li>

        <li class="c-button-group__item m-red">

            @include('component.button',[
                'modifiers' => 'm-secondary m-small',
                'title' => (count($destination->usersWantsToGo()->where('user_id', \Auth::user()->id))
                    ?
                        trans('destination.show.user.button.dontwanttogo')
                    :
                        trans('destination.show.user.button.wanttogo')
                ),
                'route' => route('flag.toggle', ['destination', $destination, 'wantstogo'])
            ])

        </li>

    </ul>

@endif

--}}

<ul class="c-destination-extra">

    @foreach($items as $item)

    <li class="c-destination-extra__item {{ $item['modifiers'] or '' }}">

        @if(isset($item['route']) && $item['route']!='')

            <a href="{{ $item['route'] }}" class="c-destination-extra__link">

        @else

            <span class="c-destination-extra__link">

        @endif

        @if(isset($item['icon']))

        <div class="c-destination-extra__icon">

            @include('component.svg.sprite',[
                'name' => $item['icon']
            ])

        </div>

        @endif

        @if(isset($item['title']))

        <div class="c-destination-extra__title">

            {{ $item['title'] }}

        </div>

        @endif

        @if(isset($item['text']))

        <div class="c-destination-extra__text">

            @include('component.tooltip',[
                'modifiers' => 'm-inverted m-bottom m-one-line m-right',
                'text' => $item['text']
            ])

        </div>

        @endif

        @if(isset($item['route']) && $item['route']!='')

            </a>

        @else

            </span>

        @endif

    </li>

    @endforeach

</ul>
