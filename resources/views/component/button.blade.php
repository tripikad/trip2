{{--

description: Button component

code: |

    @include('component.button', [
        'title' => 'Button',
        'route' => '',
        'modifiers' => $options
    ])

options:

- m-block
- m-secondary

--}}

<a href="{{ $route }}" class="c-button {{ $modifiers or '' }}">{{ $title }}</a>