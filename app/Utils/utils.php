<?php

use App\Utils;
use Carbon\Carbon;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Cocur\Slugify\Slugify;

function mail_component($component, $data = [])
{
    $view = view();

    $view->flushFinderCache();

    $contents = $view
        ->replaceNamespace('mail', resource_path('views/vendor/mail/html'))
        ->make($component, $data)
        ->render();

    return $contents;
}

function full_text_safe($string)
{
    $string = trim($string);

    $string = str_replace(
        ['-', '+', '%', '(', ')', '*', '@', '<', '>', '~', '"'],
        [
            '_minus_',
            '_plus_',
            '_percent_',
            '_bracket_o_',
            '_bracket_c_',
            '_multiply_',
            '_at_',
            '_a_bracket_l_',
            '_a_bracket_r_',
            '_about_',
            '_quote_'
        ],
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

    return (new $class())->render(...$arguments);
}

function layout($layout)
{
    return new Utils\Layout($layout);
}

function format_body($body)
{
    return (new Utils\BodyFormatter($body))
        //->fixLinks()
        ->flightmap()
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
        return trans('utils.date.today') . ' ' . $date->format('H:i');
    }
    if ($date->isYesterday()) {
        return trans('utils.date.yesterday') . ' ' . $date->format('H:i');
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
    return Redirect::to(URL::previous() . $anchor);
}

function dist($type)
{
    $path = public_path('manifest.json');
    if (is_file($path)) {
        $manifest = json_decode(file_get_contents($path), true);
    } else {
        $manifest = [
            'js' => 'main.js',
            'css' => 'main.css',
            'svg' => 'main.svg'
        ];
    }
    return '/dist/' . (is_array($manifest[$type]) ? $manifest[$type][0] : $manifest[$type]);
}

function format_link($route, $title, $blank = false)
{
    $target = $blank ? 'target="_blank"' : '';

    return '<a href="' . $route . '" ' . $target . '>' . $title . '</a>';
}

function style_vars()
{
    $json = Storage::disk('root')->get('resources/views/styles/variables.json');

    return json_decode($json);
}

function snap($value, $step = 1)
{
    return round($value / $step) * $step;
}

function google_sheet($id)
{
    $url = 'https://spreadsheets.google.com/feeds/list/' . $id . '/od6/public/values?alt=json';

    $data = json_decode(file_get_contents($url));

    return collect($data->feed->entry)->map(function ($entry) {
        return (object) collect($entry)
            ->keys()
            ->map(function ($field) use ($entry) {
                if (starts_with($field, 'gsx$')) {
                    return [str_replace('gsx$', '', $field), $entry->{$field}->{'$t'}];
                } else {
                    return false;
                }
            })
            ->filter(function ($field) {
                return $field;
            })
            ->reduce(function ($carry, $field) {
                return $carry->put($field[0], $field[1]);
            }, collect())
            ->toArray();
    });
}

function slug($title)
{
    $slugify = new Slugify();
    return $slugify->slugify($title);
}

function dusk($title)
{
    return '@' . slug($title);
}
