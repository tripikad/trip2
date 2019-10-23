@php

$title = $title ?? '';
$content = $content ?? [];
$actions = $actions ?? [];

@endphp

<div class="PhotoRow {{ $isclasses }}">

    @if (collect($content)->count())

        @foreach (collect($content)->chunk(9) as $content_row)

            <div class="PhotoRow__row">

            @foreach ($content_row->chunk(3) as $content_subrow)

                <div class="PhotoRow__subRow">

                @foreach ($content_subrow as $content_item)

                    <div class="PhotoRow__photo">

                        {!! $content_item !!}

                    </div>

                @endforeach

                </div>

            @endforeach

            </div>

        @endforeach

    @endif

    <div class="PhotoRow__actions">
        
        @foreach ($actions as $action)

        <div class="PhotoRow__action">

        {!! $action !!}
    
        </div>

        @endforeach

    </div>

</div>
