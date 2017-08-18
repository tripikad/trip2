@component('mail::newsletter', [
    'unsubscribe_route' => $unsubscribe_route,
])

<table width="100%" cellpadding="5" cellspacing="3">
    <tr>
        <td colspan="2">
            <h1>{{ $heading }}</h1>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            {!! $body !!}
        </td>
    </tr>
</table>


@endcomponent