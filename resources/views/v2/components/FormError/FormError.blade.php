@if ($errors->count())

<div class="FormError {{ $isclasses }}">

    @foreach ($errors->all() as $error)

    <div class="FormError__title">

        {{ $error }}

    </div>

    @endforeach

</div>

@endif