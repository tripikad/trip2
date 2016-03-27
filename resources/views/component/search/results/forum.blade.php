<ul class="c-search-forum">
@foreach ($content as $row)

<li class="c-search-forum__item">
    <h3 class="c-search-forum__item-title">
        <a href="{{$row->route}}" class="c-search-forum__item-title-link"><span>{{$row->title}}</span> <div class="c-badge m-inverted m-red">{{$row->comments_count}}</div></a>
        <span class="c-search-forum__item-title-date">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $row->updated_at)->format('d.m.Y H:i')}}</span>
    </h3>
    <div class="c-search-forum__item-content">
    <div class="c-search-forum__item-image" style="background-image: url({{$row->user_img}});"></div>
       <!--  <p>… uudiseid vägivallast ja inimröövidest saabus pidevalt. Kuigi ka praegu leidub Kolumbias piirkondi, kuhu ei soovitata reisida, on üldine olukord turvalisusega <span>Vietnam</span> riigis oluliselt parem, kui paarkümmend aastat tagasi. Kuritegevuse olulise …</p> -->
       <p>{{$row->short_body_text}}</p>
    </div>
</li>

@endforeach
</ul>
                    