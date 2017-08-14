@php
    $url = $url ?? '#';
    $user = $user ?? '';
    $date = $date ?? '';
@endphp
<table width="100%" cellpadding="0" cellspacing="0" class="forum-wrapper">
    <tr>
        <td width="50" valign="top">
        @if (isset($image))
            <a href="{{ $url }}"><img src="{!! $image !!}" class="user_image"></a>
        @else
            <a href="{{ $url }}"><img src="{{ asset('mail/picture_none.png') }}" class="user_image"></a>
        @endif
        </td>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-left: 10px;">
                <tr>
                    <td valign="top">
                        <a href="{{ $url }}" class="title">{{ $slot }}</a><br />

                        @if ($user)
                            <a href="{{ $url }}" class="user">{{ $user }}</a>
                        @endif

                        @if ($date)
                            <a href="{{ $url }}" class="gray">{{ $date }}</a>
                        @endif

                        @if (isset($destinations))
                            @foreach ($destinations as $destination)
                                <a href="{{ $destination['url'] }}" class="destination">{{ $destination['name'] }}</a>
                            @endforeach
                        @endif
                        @if (isset($topics))
                            @foreach ($topics as $topic)
                                <a href="{{ $topic['url'] }}" class="gray">{{ $topic['name'] }}</a>
                            @endforeach
                        @endif
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>