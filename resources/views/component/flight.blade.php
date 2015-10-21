{{--

description: Flight block

code: |

    @include('component.flight', [
        'modifiers' => $options,
        'route' => '#',
        'title' => 'Offer title',
        'image' => \App\Image::getRandom()
    ])

options:

- m-red
- m-blue
- m-green
- m-yellow
- m-orange
- m-purple

--}}

<a href="{{ $route }}" class="c-flight {{ $modifiers or '' }}">

	<h3 class="c-flight__title">{{ $title }}</h3>

	<div class="c-flight__image-wrap">

		<img src="{{ $image }}" alt="" class="c-flight__image">
	</div>
</a>