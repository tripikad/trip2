@if (session('info'))

    <div class="c-alert m-success m-fixed js-alert">

        <div class="c-alert__inner">

            {{ session('info') }}

            <span class="c-alert__close js-alert__close">&times;</span>

        </div>
    </div>

@endif
