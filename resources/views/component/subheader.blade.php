<div class="component-subheader {{ $options or ''}}">

    <div class="row">
    
        <div class="col-xs-9">

            <h3>{{ $title }}</h3>

        </div>

        <div class="col-xs-3 text-right">

            @if (isset($link_title))

                <a href="{{ $link_route }}">{{ $link_title }} ›</a>

            @endif

        </div>

    </div>

</div>