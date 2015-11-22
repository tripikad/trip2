@if (count($errors) > 0)

    <div class="c-alert m-error">

        @foreach ($errors->all() as $error)

            {{ $error }}
            <br>

        @endforeach

    </div>

@endif
