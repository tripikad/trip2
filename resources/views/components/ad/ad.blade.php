<div
    class="component-ad {{ $options or ''}}"
    style="
        background-color: {{ [
            '#3C1642',
            '#086788',
            '#C62E65',
            '#F28123',
            '#D34E24',
            '#1E3231',
            '#485665',
            '#32A287',
            '#D36135',
            '#A24936',
        ][rand(0,9)] }};
">
        
    <h3>{{ $title }}<h3>

</div>


{{--<div style="
    padding-bottom: {{ $height }}%;
    width: 100%;

">

    <h3 style="
        font-weight: normal;
        font-family: sans-serif;
        opacity: 0.8;
        text-align: center;
        margin: 0;
        padding-top: {{ isset($padding) ? $padding : ($height * 1.8) }}%;
        color: white;
    ">
    {{ $title or 'Sample ad' }}
    <h3>

</div>
--}}