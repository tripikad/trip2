{{--

title: Button

code: |

    @include('component.button', [
        'title' => 'Button',
        'route' => '',
        'modifiers' => $modifiers
    ])

modifiers:

- m-block
- m-secondary

--}}

<a href="{{ $route }}" class="c-button {{ $modifiers or '' }}">{{ $title }}</a>