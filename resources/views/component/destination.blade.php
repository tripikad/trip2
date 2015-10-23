{{--

title: Destination

code: |

    @include('component.destination', [
        'title' => 'Here is title',
        'title_route' => '',
        'subtitle' => 'Here is subtitle',
        'subtitle_route' => '',
        'modifiers' => $modifiers
    ])

modifiers:

- m-red
- m-blue
- m-green
- m-orange
- m-yellow
- m-purple

--}}

<div class="c-destination {{ $modifiers or 'm-yellow' }}">

	<div class="c-destination__header">

		<h3 class="c-destination__title"><a href="{{ $title_route }}" class="c-destination__title-link">{{ $title }} &rsaquo;</a></h3>
		<div class="c-destination__subtitle"><a href="{{ $subtitle_route }}">{{ $subtitle }} &rsaquo;</a></div>
	</div>
</div>