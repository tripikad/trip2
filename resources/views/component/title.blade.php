{{--

title: Title

description: A generic title

code: |

    @include('component.title', [
        'title' => 'Title',
        'link_route' => '',
        'modifiers' => $modifiers,
    ])

modifiers:

- m-red
- m-blue
- m-green
- m-orange
- m-yellow
- m-purple
- m-white
- m-margin
- m-large
- m-larger
- m-huge

--}}

<h2 class="c-title {{ $modifiers or '' }}">
    @if (isset($link_route)) <a href="{{ $link_route }}" class="c-title__link"> @endif
    {{ $title }}
    @if (isset($link_route)) </a> @endif
</h2>
