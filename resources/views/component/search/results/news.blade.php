
<ul class="c-search-news">

@foreach ($content as $row)

    <li class="c-search-news__item">
        <a href="{{$row->route}}" class="c-search-news__item-image" style="background-image: url({{$row->content_img}});"></a>
        <div class="c-search-news__item-content">
            <h3 class="c-search-news__item-title">
                <a href="{{ route($row->type.'.show', [$row->slug]) }}" class="c-search-news__item-title-link">{{ $row->title }}</a>
                <span class="c-search-news__item-title-date">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('d.m.Y H:i') }}</span>
            </h3>
            <p>{{ (strlen(strip_tags($row->body)) > 300) ? substr(strip_tags($row->body), 0, 300).'...' : strip_tags($row->body) }}</p>
        </div>
    </li>

@endforeach                        
                
</ul>
