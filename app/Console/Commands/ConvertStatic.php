<?php

namespace App\Console\Commands;

class ConvertStatic extends ConvertBase
{
    protected $signature = 'convert:static';

    public function getStaticNodes()
    {

        // Mis on Trip.ee, Kontakt, Kasutustingimused, Reklaam, Mis on veahind?

        $query = \DB::connection($this->connection)
            ->table('node')
            ->join('node_revisions', 'node_revisions.nid', '=', 'node.nid')
            ->whereIn('node.nid', [1534, 972, 25151, 22125, 97203]);

        return $query;
    }

    public function convertStaticNodes()
    {
        $nodes = $this->getStaticNodes()->get();

        $this->info('Converting static pages');
        $this->output->progressStart(count($nodes));

        foreach ($nodes as $node) {
            $node->uid = 1;
            $this->convertNode($node, '\App\Content', 'static', 'content.show');
            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
    }

    public function handle()
    {
        $this->convertStaticNodes();
    }
}
