<ul class="c-search__results-list m-destinations">

    <li class="c-search__results-list-item">
        <span class="c-search__results-list-item-icon">
            @include('component.svg.sprite',[
                'name' => 'icon-pin'
            ])
        </span>
        {{trans('search.tab.destination')}}
        <ul class="c-search__results-sublist">
        @foreach ($content as $row)
            <li class="c-search__results-sublist-item"><a href="{{route('destination.showSlug', $row->slug)}}" class="c-search__results-link">{{$row['name']}}</a></li>
        @endforeach
        </ul>
    </li>

</ul>