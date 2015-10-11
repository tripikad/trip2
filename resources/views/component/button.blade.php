{{--

Button component

@include('component.button', [
    'title' => 'Button',
    'route' => '',
])

--}}

<a href="{{ $route }}" class="btn {{ $buttontype or 'btn-primary' }}">{{ $title }}</a>