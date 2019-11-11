@php

$route = $route ?? '';
$title = $title ?? '';
$licence = $licence ?? '';

@endphp


<div class="StyleFooter {{ $isclasses }}">

  <div>
    @if ($route)

    <a href="{{ $route }}">

      @endif

      <div class="StyleFooter__title">

        {!! $title !!}

      </div>

      @if ($route)

    </a>

    @endif

    <div class="StyleFooter__licence">

      {!! $licence !!}

    </div>

  </div>

</div>