<div class="c-forum">

	<ul class="c-forum__list {{ $modifiers or '' }}">

		@foreach ($items as $item)

		<li class="c-forum__list-item">

			@if (isset($item['profile']))

			<div class="c-forum__list-item-profile">

				@include('component.profile', [
					'modifiers' => $item['profile']['modifiers'],
                    'route' => $item['profile']['route'],
                    'image' => $item['profile']['image'],
                    'badge' => $item['badge']
                ])
			</div>

			@endif

			<h3 class="c-forum__list-item-topic"><a href="{{ $item['route'] }}" class="c-forum__list-item-topic-link">{{ $item['topic'] }}</a></h3>

			@if (isset($item['tags']))

			<div class="c-forum__list-item-tags">

				@include('component.tags', [
					'items' => $item['tags']
                ])

			</div>

			@endif
		</li>

		@endforeach

	</ul>
</div>