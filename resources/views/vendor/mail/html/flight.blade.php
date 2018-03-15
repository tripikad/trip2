@component('mail::panel')
<table width="100%" cellpadding="0" cellspacing="0" class="flight-wrapper">
<tr>
@if (isset($image))
<th width="210" valign="top" class="flight_col">
<img src="{!! $image !!}" class="flight_image">
</th>
<th valign="top" class="flight_col">
@else
<th valign="top" colspan="2" class="flight_col">
@endif

<p class="flight_title">{{ $slot }}</p>

@component('mail::button', ['is' => 'narrow','url' =>$url ?? '#','color' => $button_color ?? 'red'])
Vaata pakkumist
@endcomponent
</th>
</tr>
</table>
@endcomponent