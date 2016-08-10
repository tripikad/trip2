
<ul class="c-search-news">

@foreach ($content as $row)

    <li class="c-search-news__item">
        <a href="{{$row->route}}" class="c-search-news__item-image" style="background-image: url({{$row->content_img}});"></a>
        <div class="c-search-news__item-content">
            <h3 class="c-search-news__item-title">
                <a href="{{$row->route}}" class="c-search-news__item-title-link">{{$row->title}}</a>
                <span class="c-search-news__item-title-date">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('d.m.Y H:i')}}</span>
            </h3>
            <!-- <p>… uudiseid vägivallast ja inimröövidest saabus pidevalt. Kuigi ka praegu leidub Kolumbias piirkondi, kuhu ei soovitata reisida, on üldine olukord turvalisusega <span>Vietnam</span> riigis oluliselt parem, kui paarkümmend aastat tagasi. Kuritegevuse olulise …</p> -->
            <p>{{$row->short_body_text}}</p>
        </div>
    </li>

@endforeach                        
                
</ul>
