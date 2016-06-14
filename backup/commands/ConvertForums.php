<?php

namespace App\Console\Commands;

class ConvertForums extends ConvertBase
{
    protected $signature = 'convert:forums';

    public function filterTerms($nid, $terms)
    {
        return \DB::connection($this->connection)
            ->table('term_node')
            ->where('term_node.nid', '=', $nid)
            ->whereIn('term_node.tid', $terms)
            ->get();
    }

    public function convert()
    {
        $i = 0;

        $count = $this->getNodes('trip_forum')->count();

        $this->info('Converting forum');
        $this->output->progressStart(($this->take > $count) ? $count : $this->take);

        $nodes = $this->getNodes('trip_forum')->skip($this->skip)->chunk($this->chunk, function ($nodes) use (&$i) {
            if ($i++ > $this->chunkLimit()) {
                return false;
            }

            foreach ($nodes as $node) {
                if (! $this->filterTerms($node->nid, [821])) {
                    // Reisikirjad

                    $model = 'App\Content';

                    if ($this->convertNode($node, $model, 'forum')) {
                        $this->convertNodeDestinations($node);
                        $this->convertNodeTopics($node);
                        $this->newNodeTopics($node);
                    }

                    $this->output->progressAdvance();
                }
            }
        });

        $this->output->progressFinish();
    }

    public function handle()
    {
        $this->convert();
    }
}
