{{--

title: User image

code: |

    @include('component.user.image', [
        'modifiers' => $modifiers,
        'image' => \App\Image::getRandom()
    ])

modifiers:

- m-circle
- m-center
- m-full
- m-mini
- m-micro
- m-normal

--}}

<div class="c-user-image {{ $modifiers or ''}}">

    <div class="c-user__image-wrap">
        <img src="{{ $image }}" alt="" class="c-user-image__image">
    </div>

</div>
