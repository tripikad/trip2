<?php

namespace App\Utils;

use Markdown;
use App\Image;
use Symfony\Component\Yaml\Yaml;

class BodyFormatter
{
    protected $body;

    public function __construct($body)
    {
        $this->body = $body;
    }

    public function markdown()
    {
        $this->body = Markdown::parse($this->body);

        return $this;
    }
    public function fixLinks()
    {
        $linksPattern = '/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(\/.*)?/';

        if (preg_match_all($linksPattern, $this->body, $matches)) {
            foreach ($matches[0] as $match) {
                $this->body = preg_replace('/https?:\/\//', '', $this->body);
                $this->body = str_replace($match, 'http://'.$match, $this->body);
            }
        }
        return $this;
    }

    public function externalLinks()
    {

        if ($filteredBody = preg_replace('/(<a href="(http|https):(?!\/\/(?:www\.)?trip\.ee)[^"]+")>/is', '\\1 target="_blank">', $this->body)) {
            $this->body = $filteredBody;
        }

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

    public function calendar()
    {
        $yamlPattern = '/(\[\[[\r\n].*[\r\n]\]\])/s';

        if (preg_match_all($yamlPattern, $this->body, $matches)) {
            foreach ($matches[1] as $match) {
                $cleanedMatch = str_replace(['[[', ']]'], '', $match);
                $cleanedMatch = preg_replace_callback(
                    "/-\s+(.+)/",
                    function ($matches) {
                        return "- '".format_body($matches[1])."'";
                    },
                    $cleanedMatch
                );
                if ($months = Yaml::parse($cleanedMatch)) {
                    $this->body = str_replace(
                        $match,
                        component('FlightCalendar')
                            ->with('months', $months)
                            ->render(),
                        $this->body
                    );
                }
            }
        }

        return $this;
    }

    public function youtube()
    {
        $pattern = "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i";

        $this->body = preg_replace_callback($pattern, function ($matches) {
            return component('Youtube')->with('id', $matches[2]);
        },
        $this->body);

        return $this;
    }

    public function vimeo()
    {
        // From https://github.com/regexhq/vimeo-regex

        $pattern = "/(http|https)?:\/\/(www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|)(\d+)(?:|\/\?)/i";

        $this->body = preg_replace_callback($pattern, function ($matches) {
            return component('Vimeo')->with('id', $matches[4]);
        },
        $this->body);

        return $this;
    }

    public function plain()
    {
        $this->body = strip_tags($this->body);
        $this->body = str_replace(["\n", "\t", "\r"], ' ', ($this->body));

        return $this;
    }

    public function trim()
    {
        $this->body = trim($this->body);

        return $this;
    }

    public function format()
    {
        return $this->body;
    }
}
