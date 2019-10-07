<?php

use App\Utils;
use Carbon\Carbon;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;

function mail_component($component, $data = [])
{
    $view = view();

    $view->flushFinderCache();

    $contents = $view->replaceNamespace(
        'mail', resource_path('views/vendor/mail/html')
    )->make($component, $data)->render();

    return $contents;
}

function full_text_safe($string)
{
    $string = trim($string);

    $string = str_replace(
        ['-', '+', '%', '(', ')', '*', '@', '<', '>', '~', '"'],
        ['_minus_', '_plus_', '_percent_', '_bracket_o_', '_bracket_c_', '_multiply_', '_at_', '_a_bracket_l_', '_a_bracket_r_', '_about_', '_quote_'],
        $string
    );

    return $string;
}

function component($component)
{
    return new Utils\Component($component);
}

function region($region, ...$arguments)
{
    $class = "\App\Http\Regions\\$region";

    return (new $class)->render(...$arguments);
}

function layout($layout)
{
    return new Utils\Layout($layout);
}

function format_body($body)
{
    return (new Utils\BodyFormatter($body))
        //->fixLinks()
        ->calendar()
        ->youtube()
        ->vimeo()
        ->markdown()
        ->externalLinks()
        ->images()
        ->format();
}

function format_description($body)
{
    return (new Utils\BodyFormatter($body))
        //->fixLinks()
        ->markdown()
        ->externalLinks()
        ->images()
        ->plain()
        ->trim()
        ->format();
}

function format_date($date)
{
    if ($date->isToday()) {
        return trans('utils.date.today').' '.$date->format('H:i');
    }
    if ($date->isYesterday()) {
        return trans('utils.date.yesterday').' '.$date->format('H:i');
    }
    if ($date->year == Carbon::now()->year) {
        return Date::parse($date)->format('j. M H:i');
    }

    return Date::parse($date)->format('j. M Y H:i');
}

function format_smtp_header(array $data)
{
    $json = json_encode($data);
    $json = preg_replace('/(["\]}])([,:])(["\[{])/', '$1$2 $3', $json);

    $str = wordwrap($json, 76, "\n   ");

    return $str;
}

function backToAnchor($anchor)
{
    return Redirect::to(URL::previous().$anchor);
}

function dist($type)
{
    //$path = public_path('manifest.json');
    //$manifest = json_decode(file_get_contents($path), true);

    // return '/dist/'.(is_array($manifest[$type]) ? $manifest[$type][0] : $manifest[$type]);

    $manifest = [
        'js' => 'https://trip-staging-static.onrender.com/main.f2c1d4.js',
        'css' => 'https://trip-staging-static.onrender.com/main.c2aa21.css',
        'svg' => 'https://trip-staging-static.onrender.com/main.svg',
    ];

    return $manifest[$type];

}

function format_link($route, $title, $blank = false)
{
    $target = $blank ? 'target="_blank"' : '';

    return '<a href="'.$route.'" '.$target.'>'.$title.'</a>';
}

function styleVars()
{
    $json = Storage::disk('root')->get('resources/views/styles/variables.json');

    return json_decode($json);
}
