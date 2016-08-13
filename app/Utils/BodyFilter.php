<?php

namespace App\Utils;

use App\Image;

class BodyFilter
{
    protected $body;

    public function __construct($body)
    {
        $this->body = $body;
    }

    public function newlines()
    {
        $this->body = nl2br($this->body);
        return $this;
    }

    public function images()
    {
        $imagePattern = '/\[\[([0-9]+)\]\]/';

        if (preg_match_all($imagePattern, $this->body, $matches)) {
            foreach ($matches[1] as $match) {
                if ($image = Image::find($match)) {
                    $this->body = str_replace(
                        "[[$image->id]]",
                        '<img src="'.$image->preset('large').'" />',
                        $this->body
                    );
                }
            }
        }

        return $this;
    }

    public function filter()
    {
        return $this
            ->images()
            ->newlines()
            ->body;
    }
}
