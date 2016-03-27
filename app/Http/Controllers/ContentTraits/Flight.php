<?php

namespace App\Http\Controllers\ContentTraits;

trait Flight
{
    public function getFlightIndex($contents, $topics)
    {
        $viewVariables = [];

        $topicsLimit = 12;
        $uniqueTopics = [];

        foreach ($contents as $content) {
            if (count($uniqueTopics) == $topicsLimit) {
                break;
            }

            if (count($content->topics)) {
                foreach ($content->topics as $topic) {
                    if (count($uniqueTopics) == $topicsLimit) {
                        break;
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

        $viewVariables['uniqueTopics'] = $uniqueTopics;

        return $viewVariables;
    }
}
