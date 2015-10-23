{{--

title: Destination info

code: |

    @include('component.destination.info',[
        'modifiers' => $options,
        'text' => 'Malta on tihedalt asustatud saareriik Vahemeres, mis koosneb 3 asustatud ja neljast asustamata saartest',
        'wiki_route' => '#',
        'definitions' => [
            [
                'term' => 'Rahvaarv',
                'definition' => '417 600 in'
            ],
            [
                'term' => 'Pindala',
                'definition' => '316 km²;'
            ],
            [
                'term' => 'Valuuta',
                'definition' => 'Euro (€, EUR)'
            ],
            [
                'term' => 'Aeg',
                'definition' => '10:23(+1h)'
            ],
        ]
    ])

options:

- m-red
- m-blue
- m-green
- m-yellow
- m-orange
- m-purple

--}}

<div class="c-destination-info {{ $modifiers or 'm-yellow' }}">

    <p class="c-destination-info__text">{{ $text }}
    @if (isset($wiki_route))
        <a href="{{ $wiki_route }}">Wikipedia &rsaquo;</a>
    @endif
    </p>

    @if (isset($definitions))

    <dl class="c-destination-info__definition-list">

        @foreach ($definitions as $item)

        <dt class="c-destination-info__definition-list-term">{{ $item['term'] }}</dt>
        <dd class="c-destination-info__definition-list-definition">{{ $item['definition'] }}</dd>

        @endforeach

    </dl>

    @endif

</div>