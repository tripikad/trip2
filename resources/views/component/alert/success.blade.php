@if (session('info'))

    <div class="c-alert m-success">

        {{ session('info') }}

        <span class="c-alert__close js-close-element">&times;</span>

    </div>

@endif
