<ul class="c-list {{ $modifiers or '' }}">

	@foreach ($items as $item)

    <li class="c-list__item {{ $item['modifiers'] or '' }}">

    	@if (isset($item['icon']))

    	<div class="c-list__item-icon">

    		@include('component.icon', ['icon' => $item['icon'] ])

    	</div>

    	@endif

        <h3 class="c-list__item-title"><a href="{{ $item['route'] }}" class="c-list__item-title-link">{{ $item['title'] }}</a></h3>

        @if (isset($item['text']))

        <p class="c-list__item-text">{{ $item['text'] }}</p>

        @endif

    </li>

    @endforeach

</ul>