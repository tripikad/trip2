@php 

$errors = $errors ?? collect();

@endphp

@if ($errors->count())

<div class="HeaderError {{ $isclasses }}">

    @foreach ($errors->all() as $error)

    <div class="HeaderError__title">

        {{ $error }}

    </div>

    @endforeach

</div>

@endif