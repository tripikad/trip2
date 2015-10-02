<div class="component-subheader {{ $options or ''}}">

    <div class="row">
    
        <div class="col-xs-8">

            <h3>{{ $title }}</h3>

        </div>

        <div class="col-xs-4 text-right">

            @if ($link_title)

                <a href="{{ $link_route }}">{{ $link_title }} ›</a>

            @endif

        </div>

    </div>

</div>