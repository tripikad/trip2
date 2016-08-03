<?php

use App\Utils;

function component($component)
{
    return new Utils\Component($component);
}

function region($component, ...$arguments)
{
    $class = "\App\Http\Regions\\$component";

    return (new $class)->render(new Request, ...$arguments);
}

function format_smtp_header(array $data)
{
    $json = json_encode($data);
    $json = preg_replace('/(["\]}])([,:])(["\[{])/', '$1$2 $3', $json);

    $str = wordwrap($json, 76, "\n   ");

    return $str;
}
