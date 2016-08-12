@php


$background = $background ?? '';
$header = $header ?? '';
$title = $title ?? '';

@endphp

<div class="MastHeadNews {{ $isclasses }}" 
	style="background-image: linear-gradient(
      rgba(0, 0, 0, 0.1),
      rgba(0, 0, 0, 0.3)
    ), url({{ $background }});">

    <div class="MastHeadNews__header">

        {{ $header }}

    </div>

    <div class="MastHeadNews__title">

        {{ $title }}

    </div>

</div>
