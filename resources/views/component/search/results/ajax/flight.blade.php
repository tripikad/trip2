<ul class="c-search__results-list m-offers">
    <li class="c-search__results-list-item">
        <span class="c-search__results-list-item-icon">
            @include('component.svg.sprite',[
                'name' => 'icon-tickets'
            ])
        </span>
        Lennupakkumised
        <ul class="c-search__results-sublist">
        @foreach ($content as $row)
            <li class="c-search__results-sublist-item"><a href="{{route('content.show', ['flight', $row])}}" class="c-search__results-link">{{$row['title']}}</a></li>
        @endforeach
        </ul>
    </li>
</ul>