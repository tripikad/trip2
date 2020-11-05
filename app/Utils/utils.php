<?php

use App\Utils;
use Carbon\Carbon;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Cocur\Slugify\Slugify;
use Illuminate\Support\Collection;

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
        ->polls()
        ->calendar()
        ->markdown()
        ->youtube()
        ->vimeo()
        ->externalLinks()
        ->images()
        ->replaceQuotes()
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

function format_comment($body)
{
    return (new Utils\BodyFormatter($body))
        ->markdown()
        ->youtube()
        ->vimeo()
        ->formatLinks()
        ->externalLinks()
        ->replaceQuotes()
        ->format();
}

function format_comment_edit($body)
{
    return (new Utils\BodyFormatter($body))
        ->markdown()
        ->vimeo()
        ->formatLinks()
        ->externalLinks()
        ->replaceQuotes()
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
    $path = public_path('/dist/manifest.json');
    $manifest = null;
    if (is_file($path)) {
        $manifest = json_decode(file_get_contents($path), true);
    } else
        return null;

    switch ($type) {
        case "css":
            return $manifest['main.css'];
        case "js":
            return $manifest['main.js'];
        case "svg":
            return $manifest['main.svg'];
    }

    return null;
}

function format_link($route, $title, $blank = false)
{
    $target = $blank ? 'target="_blank"' : '';

    return '<a href="' . $route . '" ' . $target . '>' . $title . '</a>';
}

function styles($value = null)
{
    if ($value == null) {
        return config('styles');
    }
    if ($value && ($stylevar = config("styles.$value"))) {
        return $stylevar;
    }
    return '';
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

function spacer($value = 'md')
{
    $spacer = styles('spacer');

    $size_map = ['xs' => 0.25, 'sm' => 0.5, 'md' => 1, 'lg' => 2];

    if (isset($value) && is_string($value) && $size_map[$value]) {
        return 'calc(' . $size_map[$value] . ' * ' . $spacer . ')';
    } elseif (isset($value) && !is_string($value)) {
        return 'calc(' . $value . ' * ' . $spacer . ')';
    } else {
        return 'calc(' . $size_map['sm'] . ' * ' . $spacer . ')';
    }
}

function items($items = null)
{
    if ($items instanceof Collection) {
        return $items;
    }

    if (is_array($items)) {
        return $items;
    }

    return collect([$items]);
}

function only_numbers($string)
{
    return preg_replace('/[^0-9]/', '', $string);
}

function errorKeys()
{
    if (session()->get('errors')) {
        return collect(
            session()
                ->get('errors')
                ->getBag('default')
                ->messages()
        )->keys();
    }
    return null;
}

function format_currency($price)
{
    return $price . config('site.currency.eur');
}
