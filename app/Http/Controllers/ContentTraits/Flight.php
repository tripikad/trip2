<?php

namespace App\Http\Controllers\ContentTraits;

trait Flight
{
    public function getFlightIndex($contents, $topics)
    {
        $viewVariables = [];

        $uniqueTopics = [];
        foreach ($contents as $content) {
            if (count($content->topics)) {
                foreach ($content->topics as $topic) {
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
            $topics = $topics->take(12);

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
