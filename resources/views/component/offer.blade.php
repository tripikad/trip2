{{--

description: Offer block

code: |

    @include('component.offer', [
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

<a href="{{ $route }}" class="c-offer {{ $modifiers or '' }}">

	<h3 class="c-offer__title">{{ $title }}</h3>

	<div class="c-offer__image-wrap">

		<img src="{{ $image }}" alt="" class="c-offer__image">
	</div>
</a>