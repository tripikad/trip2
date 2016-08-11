@php


$background = $background ?? '/photos/header2.jpg';
$title = $title ?? '';

@endphp

<div class="MastHeadNews {{ $isclasses }}" 
	style="background-image: linear-gradient(
      rgba(0, 0, 0, 0.1),
      rgba(0, 0, 0, 0.3)
    ), url({{ $background }});">

    <a href="/" class="MastHeadNews__icon">

            <component
                is="Icon"
                icon="tripee_logo_plain"
                size="xl"
            ></component>

        </a>

    <div class="MastHeadNews__title">

        {{ $title }}

    </div>

</div>
