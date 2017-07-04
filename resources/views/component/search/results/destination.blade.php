<ul class="c-search-destinations">

@foreach ($content as $row)

    <li class="c-search-destinations__item">
        <a href="{{route('destination.showSlug', [$row->slug])}}" class="c-search-destinations__item-image" style="background-image: url({{\App\Image::getRandom()}});"></a>
        <div class="c-search-destinations__item-content">
            <h3 class="c-search-destinations__item-title">
                <a href="{{route('destination.showSlug', [$row->slug])}}" class="c-search-destinations__item-title-link">{{$row['name']}}</a>
            </h3>
            <ul class="c-search-destinations__item-info">
                <li>{{$row['path']}}</li>
                <!-- <li><a href="#" class="c-search-destinations__item-info-link">Asia</a></li>
                <li><a href="#" class="c-search-destinations__item-info-link">Vietnam</a></li>
                <li><a href="#" class="c-search-destinations__item-info-link">Hanoi</a></li> -->
            </ul>
        </div>
    </li>

@endforeach                        

</ul>