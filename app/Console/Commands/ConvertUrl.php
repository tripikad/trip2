<?php

namespace App\Console\Commands;

class ConvertUrl extends ConvertBase
{
    protected $signature = 'convert:url';

    public function generateMovedTermAliases()
    {

        // dump($this->topicMap);

        collect($this->topicMap)
            ->filter(function ($value) {
                return collect($value)->has('move');
            })
            ->map(function ($value, $key) {
                return (object) [
                    'from' => $this->getTermByName($key)->tid,
                    'to' => $this->getTermByName(collect($value)->first())->tid,
                ];
            })
            ->map(function ($moveMap) {
                $alias = $this->getTermAlias($moveMap->from);

                return (object) [
                    'path1' => 'taxonomy/term/'.$moveMap->from,
                    'path2' => $alias ? $alias->dst : null,
                    'aliasable_id' => $moveMap->to,
                ];
            })
            ->map(function ($moveMap) {
                dump($moveMap);

                return $moveMap;
            })
            ->each(function ($moveMap) {
                \DB::table('aliases')->insert([
                    'aliasable_id' => $moveMap->aliasable_id,
                    'aliasable_type' => 'topic',
                    'path' =>  $moveMap->path1,
                ]);

                if ($moveMap->path2) {
                    \DB::table('aliases')->insert([
                        'aliasable_id' => $moveMap->aliasable_id,
                        'aliasable_type' => 'topic',
                        'path' =>  $moveMap->path2,
                    ]);
                }
            });
    }

    public function generateDeletedTermAliases()
    {
        collect($this->topicMap)
            ->filter(function ($value) {
                return collect($value)->has('delete');
            })
            ->map(function ($value, $key) {
                return $this->getTermByName($key)->tid;
            })
            ->map(function ($tid) {
                $alias = $this->getTermAlias($tid);

                return (object) [
                    'path' => $alias ? $alias->dst : null,
                    'aliasable_id' => null,
                ];
            })
            ->filter(function ($deleteMap) {
                return $deleteMap->path;
            })
            ->map(function ($deleteMap) {
                dump($deleteMap);

                return $deleteMap;
            })
            ->each(function ($deleteMap) {
                \DB::table('aliases')->insert([
                    'aliasable_id' => 0,
                    'aliasable_type' => 'topic',
                    'path' =>  $deleteMap->path,
                ]);
            });
    }

    public function handle()
    {
        $this->generateMovedTermAliases();
        $this->generateDeletedTermAliases();
    }
}
