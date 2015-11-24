@if (count($errors) > 0)

    <div class="c-alert m-error js-alert">

        @foreach ($errors->all() as $error)

            {{ $error }}
            <br>

        @endforeach

        <span class="c-alert__close js-alert__close">&times;</span>

    </div>

@endif
