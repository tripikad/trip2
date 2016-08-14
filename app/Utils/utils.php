<?php

use App\Utils;

use Carbon\Carbon;

function component($component)
{
    return new Utils\Component($component);
}

function region($component, ...$arguments)
{
    $class = "\App\Http\Regions\\$component";

    return (new $class)->render(...$arguments);
}

function format_body($body)
{
    return (new Utils\BodyFormatter($body))->format();
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
