@php

$background = $background ?? '';
$header = $header ?? '';
$title = $title ?? '';
$meta = $meta ?? '';

@endphp

<div class="NewsMasthead {{ $isclasses }}" 
	style="background-image: linear-gradient(
      rgba(0, 0, 0, 0),
      rgba(0, 0, 0, 0.4)
    ), url({{ $background }});">

    <div class="container">

        <div class="NewsMasthead__header">

        	{!! $header !!}
        	
        </div>

        <div class="row row-center">

        <div class="col-9">

        <div class="NewsMasthead__content">

        	<div class="NewsMasthead__title">

            {!! $title !!}

            </div>

            <div class="NewsMasthead__meta">

            {!! $meta !!}

        	</div>

        </div>

        </div>

        </div>  

    </div>

</div>
