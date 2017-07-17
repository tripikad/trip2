<?php

use App\Utils;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;

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
    return (new Utils\BodyFormatter($body))->format();
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
        return $date->format('j. M H:i');
    }

    return $date->format('j. M Y H:i');
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
