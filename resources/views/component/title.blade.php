{{--

description: A generic title

code: |

    @include('component.title', [
        'title' => 'Title',
        'link_route' => '',
        'modifiers' => $options,
    ])

options:

- m-red
- m-blue
- m-green
- m-orange
- m-yellow
- m-purple

--}}

<h2 class="c-title {{ $modifiers or 'm-yellow' }}">
    @if (isset($link_route)) <a href="{{ $link_route }" class="c-title__link"> @endif
    {{ $title }}
    @if (isset($link_route)) </a> @endif
</h2>