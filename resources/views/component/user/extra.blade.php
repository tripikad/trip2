{{--

title: User extra

code: |

    @include('component.user.extra', [
        'items' => [
            [
                'icon' => 'icon-offer',
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

<ul class="c-user-extra">

    @foreach($items as $item)

    <li class="c-user-extra__item">

        @if(isset($item['route']) && $item['route']!='')

            <a href="{{ $item['route'] }}" class="c-user-extra__item-link">

        @else

            <span class="c-user-extra__item-link">

        @endif

        @if(isset($item['icon']))

        <div class="c-user-extra__item-icon">

            @include('component.svg.sprite',[
                'name' => $item['icon']
            ])

        </div>

        @endif

        @if(isset($item['title']))

        <div class="c-user-extra__item-title">

            {{ $item['title'] }}

        </div>

        @endif

        @if(isset($item['text']))

        <div class="c-user-extra__item-text">

            <span class="c-user-extra__item-text-mobile">({{$item['text']}})</span>

            <div class="c-user-extra__item-text-desktop">

            @include('component.tooltip',[
                'modifiers' => 'm-inverted m-bottom m-one-line',
                'text' => $item['text']
            ])

            </div>
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
