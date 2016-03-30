<ul class="c-search-flights">

@foreach ($content as $row)

    <li class="c-search-flights__item">
        <a href="{{$row->route}}" class="c-search-flights__item-image" style="background-image: url({{$row->content_img}});"></a>
        <div class="c-search-flights__item-content">
            <h3 class="c-search-flights__item-title">
                <a href="{{$row->route}}" class="c-search-flights__item-title-link">{{$row->title}}</a>
                <span class="c-search-flights__item-title-date">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('d.m.Y H:i')}}</span>
            </h3>
            <ul class="c-search-flights__item-info">
                <li>Hanoi, Vietnam</li>
                <li>Jaanuar – Veebruar 2017</li>
            </ul>
        </div>
    </li>

@endforeach
 
</ul>