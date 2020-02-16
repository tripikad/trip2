<?php

return [
    'title' => 'Uudiskiri',

    'started_at' => 'Algus:',
    'ended_at' => 'Lõpetatud: ',
    'sent' => 'Saadetud: ',
    'tag.future' => 'ootel',

    'button.preview' => 'Vaata eelvaadet',
    'button.view.sent' => 'Vaata kirja',
    'button.edit' => 'Muuda kirja',

    'subscribe.info.general' =>
        'Liitumisel saadetakse sulle kuni 3 korda nädalas uusi lennupakkumisi. Täpsemate pakkumiste reeglite määramiseks <a href="' .
        route('login.form') .
        '">logi sisse</a> ja tule lennupakkumiste leheküljele tagasi. Kui sul pole veel kasutajat siis esmalt <a href="' .
        route('register.form') .
        '">registreeru kasutajaks</a>.',

    'subscribe.flight.heading' => 'Lennupakkumised e-posti',
    'subscribe.field.email' => 'Sinu e-post',
    'subscribe.field.destinations' => 'Vali kuni :max sihtkohta',
    'subscribe.field.price_error' => 'Soovin kõiki veahinna pakkumisi',
    'button.subscribe_flight' => 'Kinnitan',
    'subscribe.field.newsletter_notify' => 'Soovin saada nädala uudiskirja',

    'button.subscribe_processing' => 'Palun oota...',

    'error.already_subscribed' => 'Oled juba liitunud lennupakkumiste uudiskirjaga!',
    'error.max_limit_exceeded' => 'Viga! :max sihtkohta on lubatud kokku sisestada!',
    'error.empty' => 'Uudiskiri ei tohiks olla tühi!',
    'error.wrong_date_format' => 'Viga! :date pole õiges formaadis või pole tõene kuupäev!',

    'subscribed.flight.successfully' => 'Oled lennupakkumiste teavituste saajate nimekirja lisatud!',
    'subscribed.flight.detailed.successfully' => 'Sinu lennupakkumiste teavituste muudatused on salvestatud!',
    'content.modified.successfully' => 'Uudiskirja sisu on edukalt muudetud!',

    'field.content' => 'Sisu (HTML, tekst, [[token]] viited)',
    'field.visible_from' => 'Kuva kuupäevast alates (N: ' . Carbon\Carbon::now()->format('d.m.Y') . ')',
    'field.visible_to' =>
        'Ära kuva enam kuupäevast (N: ' .
        Carbon\Carbon::now()
            ->addDays(14)
            ->format('d.m.Y') .
        ')',

    'unsubscribed.successfully.title' => 'Oled uudiskirjast lahkunud.',
    'unsubscribed.successfully.body' =>
        'Oled seda tüüpi uudiskirjade nimekirjast nüüd kustutatud.<br><br>Kui sind häirivad veel mingit tüüpi uudiskirjad siis neid saad lihtsasti tühistada logides sisse oma kontosse.',

    'cheatsheet.content' => '
        <b>[[the_flight]]</b> - Kindel lennupakkumine (toimib sihtkoha järgi lennupakkumise uudiskirjaga ainult)<br>
        <b>[[type:flight|take:3]]</b> - Kuvab 3 viimast lennupakkumist<br>
        <b>[[type:forum,buysell,expat|take:3|skip:1]]</b> - Jätab vahele 1 postituse, kuvab pärast seda 3 viimast foorumi, ost-müük, elu välismaal postitust<br>
        <b>[[type:travelmate|take:3|order_by:pop]]</b> - Kuvab 3 populaarsemat reisikaaslaste postitust. Ajavahemik võetakse viimase saadetud kirja järgi, "Pole ammu näinud" kirja puhul alates kuupäevast, mil kasutaja viimati sisse logis.<br>
        <b>[[type:news|take:3|skip:3|order_by:created_at,asc]]</b> - Jätab vahele 3 postitust, kuvab pärast neid 3 esimest uudist<br><br>
        
        Võimalikud <b>order_by</b> väärtused: <b>created_at</b> | <b>id</b> | <b>updated_at</b> | <b>pop</b> | <b>created_at,asc</b> | <b>id,asc</b>...<br>
        Võimalikud <b>type</b> väärtused: <b>flight</b> | <b>forum</b> | <b>buysell</b> | <b>expat</b> | <b>travelmate</b> | <b>news</b> | <b>shortnews</b>
    '
];
