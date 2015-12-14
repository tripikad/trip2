<?php

namespace App;

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
}
