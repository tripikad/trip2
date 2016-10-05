<ul class="c-search-forum">
@if (isset($content) && count($content))
    @foreach ($content as $row)
    <li class="c-search-forum__item">
        <h3 class="c-search-forum__item-title">
            <a href="{{ route($row->type.'.show', [$row->slug]) }}" class="c-search-forum__item-title-link"><span>{{$row->title}}</span> <div class="c-badge m-inverted m-red">{{ $row->comments->count() }}</div></a>
            <span class="c-search-forum__item-title-date">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $row->updated_at)->format('d.m.Y H:i')}}</span>
        </h3>
        <div class="c-search-forum__item-content">
        <div class="c-search-forum__item-image"@if ($row->user) style="background-image: url({{ $row->user->imagePreset() }});"@endif></div>
           <p>{{ (strlen(strip_tags($row->body)) > 300) ? substr(strip_tags($row->body), 0, 300).'...' : strip_tags($row->body) }}</p>
        </div>
    </li>

    @endforeach
@endif
</ul>
                    