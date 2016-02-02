<?php

namespace App;

use Carbon\Carbon;

class Main
{
    public static function getBodyFilteredAttribute($object)
    {
        $pattern = '/\[\[([0-9]+)\]\]/';
        $filteredBody = $object->body;

        if (preg_match_all($pattern, $filteredBody, $matches)) {
            foreach ($matches[1] as $match) {
                if ($image = Image::find($match)) {
                    $filteredBody = str_replace("[[$image->id]]", '<img src="'.$image->preset('medium').'" />', $filteredBody);
                }
            }
        }

        return nl2br($filteredBody);
    }

    public static function getExpireData($type, $withField = 0)
    {
        $names = ['daysFrom', 'daysTo'];
        $data = null;

        if (config("content_$type.index.expire.field")) {
            if ($withField == 1) {
                $data['field'] = config("content_$type.index.expire.field");
            }

            if (config("content_$type.index.expire.type") == 'date') {
                $format = 'Y-m-d';
            } else {
                $format = 'Y-m-d H:i:s';
            }

            foreach ($names as $name) {
                if (config("content_$type.index.expire.$name") && ! is_numeric(config("content_$type.index.expire.$name"))) {
                    $data[$name] = config("content_$type.index.expire.field");
                } elseif (config("content_$type.index.expire.$name")) {
                    $data[$name] = Carbon::now()->addDays(config("content_$type.index.expire.$name"))->format($format);
                } else {
                    $data[$name] = Carbon::now()->format($format);
                }
            }
        }

        return $data;
    }
}
