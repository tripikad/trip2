@component('mail::newsletter', [
    'unsubscribe_id' => $unsubscribe_id,
])

<table width="100%" cellpadding="5" cellspacing="3">
    <tr>
        <td colspan="2">
            <h1>Leidsime Sulle sobiva pakkumise Andamani saartele!</h1>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h2>Vaata pakkumist ja sobivuse korral broneeri piletid:</h2>

            @component('mail::flight', [
                'image' => 'https://trip.ee/images/large/Screen-Shot-2017-08-14-at-17.30.11_ktct.png',
                'url' => '#test',
                'button_color' => 'blue',
            ])
            Lennupiletid talvel Tallinnast eksootilistele Andamani saartele alates 472€
            @endcomponent

            @component('mail::promotion.button', [
                'url' => '#',
                'modifier' => 'offset-top offset-bottom',
            ])
                Credit24 annab ära 25 000€ reisiraha! Uuri lähemalt!
            @endcomponent

            <img src="http://www.demareadmare.lv/images/airlines/airbaltic.jpg" class="offset-bottom">
        </td>
    </tr>
</table>


@endcomponent
