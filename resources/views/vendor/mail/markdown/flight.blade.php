@component('mail::panel')
    {{ $slot }}

    @component('mail::button', [
        'url' =>  $url ?? '#',
    ])
        Vaata pakkumist
    @endcomponent
@endcomponent