<?php

namespace App\Console\Commands;

class ConvertIndexAliases extends ConvertBase
{
    protected $signature = 'convert:indexAliases';
    private $items = [];

    public function insertItem($aliasable_type, $path, $route_type)
    {
        $this->items[] = collect([
            'aliasable_type' => $aliasable_type,
            'path' => $path,
            'route_type' => $route_type,
        ]);
    }

    public function convertIndexAliases()
    {
        $this->insertItem('content.index', 'foorum', 'forum');
        $this->insertItem('content.index', 'soodsad_lennupiletid', 'flight');
        //$this->insertItem('content.index', 'vabateema', ''); 404
        //$this->insertItem('content.index', 'reisipakkumised', ''); 404
        $this->insertItem('content.index', 'ostmuuk', 'buysell');
        $this->insertItem('content.index', 'reisikaaslased', 'travelmate');
        $this->insertItem('content.index', 'uudised', 'news');
        $this->insertItem('content.index', 'pildid', 'photo');
        $this->insertItem('content.index', 'eluvalismaal', 'expat');
        $this->insertItem('content.index', 'blog', 'blog');

        $items = collect($this->items);

        $this->info('Converting index aliases');
        $this->output->progressStart(($this->take > $items->count()) ? $items->count() : $this->take);
        $nodes = $items->chunk($this->chunk);
        foreach ($nodes as $node_chunk) {
            foreach ($node_chunk as $node) {
                $this->convertStaticAlias(
                    $node['aliasable_type'],
                    $node['path'],
                    $node['route_type']
                );
            }

            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
    }

    public function handle()
    {
        $this->convertIndexAliases();
    }
}
