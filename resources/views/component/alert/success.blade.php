@if (session('info'))

    <div class="c-alert m-success js-alert">

        {{ session('info') }}

        <span class="c-alert__close js-alert__close">&times;</span>

    </div>

@endif
