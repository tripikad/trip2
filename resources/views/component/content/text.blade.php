<ul class="list-inline">

    <li>
    
        {!! view('component.user.link', ['user' => $content->user]) !!}

    </li>

    </li>

        {{ $content->created_at->diffForHumans() }}

    </li>

@if (count($content->comments))

    <li>

        {{ trans('content.row.text.comment', [
            'updated_at' => $content->updated_at->diffForHumans()
        ]) }}
    
    <li>

@endif

@if (count($content->destinations))

    <li>

        {!! $content->destinations->implode('name', '</li><li>') !!}

    </li>

@endif

@if (count($content->topics))

    <li>

        {!! $content->topics->implode('name', '</li><li>') !!}

    </li>

@endif

</ul>