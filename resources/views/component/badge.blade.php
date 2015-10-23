{{--

title: Badge

code: |

    @include('component.badge', [
        'modifiers' => $options,
        'count' => 4
    ])

options:

- m-inverted

--}}

<div class="c-badge {{ $modifiers or '' }}">
	{{ $count }}
</div>