<?php

namespace App\Utils;

use GrahamCampbell\Markdown\Facades\Markdown;
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
        $this->body = Markdown::convertToHtml($this->body);

        return $this;
    }

    public function fixLinks()
    {
        $linksPattern = '/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(\/.*)?/';

        if (preg_match_all($linksPattern, $this->body, $matches)) {
            foreach ($matches[0] as $match) {
                $this->body = preg_replace('/https?:\/\//', '', $this->body);
                $this->body = str_replace($match, 'http://' . $match, $this->body);
            }
        }

        return $this;
    }

    public function formatLinks()
    {
        $pattern = '/(<a.*?<\/a>|<img.*?\/>)(*SKIP)(*F)|(http|https):\/\/\S+/';

        $this->body = preg_replace_callback(
            $pattern,
            function ($matches) {
                $match = str_replace('</p>', '', $matches[0]);
                return '<a href="' . $match . '" target="_blank">' . $match . '</a>';
            },
            $this->body
        );

        return $this;
    }

    public function externalLinks()
    {
        if (
            $filteredBody = preg_replace(
                '/(<a href="(http|https):(?!\/\/(?:www\.)?trip\.ee)[^"]+")>/is',
                '\\1 target="_blank">',
                $this->body
            )
        ) {
            $this->body = $filteredBody;
        }

        return $this;
    }

    public function flightmap()
    {
        $flightmapPattern = '/\[\[flightmap:(.*)\]\]/';

        $this->body = preg_replace_callback(
            $flightmapPattern,
            function ($matches) {
                $airports = collect(explode('-', str_replace([';', ',', ' ', '  '], '-', strtoupper($matches[1]))))
                    ->map(function ($a) {
                        return trim($a);
                    })
                    ->map(function ($a) {
                        return collect(config('airports'))
                            ->where('iata', $a)
                            ->first();
                    });

                return component('Dotmap')
                    ->is('center')
                    ->with('height', 25)
                    ->with('lines', $airports)
                    ->with('mediumdots', $airports->withoutLast())
                    ->with('largedots', [$airports->last()])
                    ->with('linecolor', 'blue')
                    ->with('mediumdotcolor', 'white')
                    ->with('largedotcolor', 'cyan-light');
            },
            $this->body
        );

        return $this;
    }

    public function polls()
    {
        $pollsPattern = '/\[\[poll:([0-9]+)\]\]/';

        if (preg_match_all($pollsPattern, $this->body, $matches)) {
            if (isset($matches[1]) && $matches[1] && is_array($matches[1])) {
                foreach ($matches[1] as $poll_id) {
                    $id = intval($poll_id);

                    $component = component('Poll')
                        ->with('id', $id);

                    $this->body = str_replace(
                        "[[poll:{$id}]]",
                        $component,
                        $this->body
                    );
                }
            }
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
                        '<img src="' . $image->preset('large') . '" />',
                        $this->body
                    );
                }
            }
        }

        return $this;
    }

    public function timetable()
    {
        $yamlPattern = '/(\[\[[\r\n].*[\r\n]\]\])/sU';

        if (preg_match_all($yamlPattern, $this->body, $matches)) {
            foreach ($matches[0] as $match) {
                $cleanedMatch = str_replace(['[[', ']]'], '', $match);
                $cleanedMatch = preg_replace_callback(
                    '/-\s+(.+)/',
                    function ($matches) {
                        return "- " . format_body($matches[1]);
                    },
                    $cleanedMatch
                );

                $cleanedMatch = preg_replace('/^[ \t]*[\r\n]+/m', '', $cleanedMatch);

                if ($months = Yaml::parse($cleanedMatch)) {
                    $this->body = str_replace(
                        $match,
                        component('FlightTimetable')
                            ->with('months', $months)
                            ->render(),
                        $this->body
                    );
                }
            }
        }

        return $this;
    }

    public function calendar()
    {
        $calendarPattern = '/\[\[calendar:(\d{4}-\d{2};\d{4}-\d{2};[A-Za-z_-]+;[A-Za-z_-]+)\]\]/';

        if (preg_match_all($calendarPattern, $this->body, $matches)) {
            if (isset($matches[1]) && $matches[1] && is_array($matches[1])) {
                foreach ($matches[1] as $calData) {
                    $data = explode(';', $calData);
                    if ($data && is_array($data)) {
                        $startMonth = $data[0];
                        $endMonth = $data[1];
                        $startCode = $data[2];
                        $endCode = $data[3];

                        $component = component('FlightCalendar')
                            ->with('start-month', $startMonth)
                            ->with('end-month', $endMonth)
                            ->with('start-code', $startCode)
                            ->with('end-code', $endCode);

                        $this->body = str_replace(
                            "[[calendar:{$calData}]]",
                            $component,
                            $this->body
                        );
                    }
                }
            }
        }

        return $this;
    }

    public function youtube()
    {
        $markdown_pattern = '#<a(.*?)(?:href="https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch?.*?v=))([\w\-]{10,12}).*<\/a>#x';
        $plain_link_pattern = '~(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com/(?:(?:watch)?\?(?:.*&)?vi?=|(?:embed|vi?|user)/))([^?&"\'>\s]+)(?![^<]*>)\S*~';

        $this->body = preg_replace_callback(
            $markdown_pattern,
            function ($matches) {
                if (isset($matches[2]))
                    return component('Youtube')->with('id', $matches[2]);
            },
            $this->body
        );

        $this->body = preg_replace_callback(
            $plain_link_pattern,
            function ($matches) {
                if (isset($matches[1]))
                    return component('Youtube')->with('id', $matches[1]);
            },
            $this->body
        );

        return $this;
    }

    public function vimeo()
    {
        // From https://github.com/regexhq/vimeo-regex

        $pattern =
            '/(http|https)?:\/\/(www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|)(\d+)(?:|\/\?)/i';

        $this->body = preg_replace_callback(
            $pattern,
            function ($matches) {
                return component('Vimeo')->with('id', $matches[4]);
            },
            $this->body
        );

        return $this;
    }

    public function plain()
    {
        $this->body = strip_tags($this->body);
        $this->body = str_replace(["\n", "\t", "\r"], ' ', $this->body);

        return $this;
    }

    public function replaceQuotes()
    {
        $this->body = str_replace('&quot;', "\"", $this->body);

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
