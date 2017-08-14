@php
    $url = $url ?? '#';
    $date = $date ?? '';
@endphp
<table width="100%" cellpadding="0" cellspacing="0" class="news-wrapper">
    <tr>
        @if (isset($image))
            <th width="210" class="news_col">
                <a href="{{ $url }}"><img src="{!! $image !!}" class="news_image"></a>
            </th>
            <th class="news_col">
        @else
            <th colspan="2" class="news_col">
        @endif
            <a href="{{ $url }}" class="title">{!! $slot !!}</a><br>
            <a href="{{ $url }}" class="gray">{{ $date }}</a>
        </th>
    </tr>
</table>