<?php

use App\Utils;

function component($component, $with = []) {

    return (new Utils\Component($component, $with));
        
}

function format_smtp_header(array $data)
{
    $json = json_encode($data);
    $json = preg_replace('/(["\]}])([,:])(["\[{])/', '$1$2 $3', $json);

    $str = wordwrap($json, 76, "\n   ");

    return $str;
}

