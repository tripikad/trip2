<?php

namespace App\Console\Commands;

use DB;

class ConvertUrl extends ConvertBase
{
    protected $signature = 'convert:url';

    public function handle()
    {
    
        // dump($this->topicMap);

        collect($this->topicMap)
            ->filter(function($value) {
                return collect($value)->has('move');
            })
            ->map(function($value, $key) {
                return (object) [
                    'from' => $this->getTermByName($key)->tid,
                    'to' => $this->getTermByName(collect($value)->first())->tid
                ];
            })
            ->map(function($moveMap) {
                $alias = $this->getTermAlias($moveMap->from);
                return [
                    'path1' => 'taxonomy/term/'.$moveMap->from,
                    'path2' => $alias ? $alias->dst : null,
                    'aliasable_id' => $moveMap->to,
                    'aliasable_type' => 'topic',
                ];
            })
            ->each(function($moveMap) {
                dump($moveMap);
            });
    }

};