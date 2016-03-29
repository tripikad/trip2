<?php

namespace App\Http\Controllers\ContentTraits;

use App\Content;
use App\Main;

trait Flight
{
    public function getFlightIndex($contents, $topics)
    {
        $viewVariables = [];

        $types = [
            'about' => [
                'take' => 1,
                'id' => 1534,
                'status' => 1,
            ],
            'forums' => [
                'skip' => null,
                'take' => 5,
                'type' => ['forum', 'buysell', 'expat'],
                'status' => 1,
                'latest' => 'created_at',
                'whereBetween' =>
                    Main::getExpireData('buysell', 1) +
                    ['only' => 'buysell'],
            ],
        ];

        $viewVariables = Main::getContentCollections($types);

        /* To-do V2
        $topicsLimit = 12;
        $uniqueTopics = [];

        foreach ($contents as $content) {
            if (count($content->topics)) {
                foreach ($content->topics as $topic) {
                    if (count($uniqueTopics) == $topicsLimit) {
                        break 2;
                    }

                    if (! in_array($topic->name, $uniqueTopics)) {
                        $uniqueTopics[] = [
                            'name' => $topic->name,
                            'id' => $topic->id,
                        ];
                    }
                }
            }
        }

        if (! count($uniqueTopics)) {
            $topics = $topics->take($topicsLimit);

            if (count($topics)) {
                foreach ($topics as $id => $name) {
                    $uniqueTopics[] = [
                        'name' => $name,
                        'id' => $id,
                    ];
                }
            }
        }

        $uniqueTopics = collect($uniqueTopics);

        $viewVariables['uniqueTopics'] = $uniqueTopics;*/

        return $viewVariables;
    }
}
