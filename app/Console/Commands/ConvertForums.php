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

        $nodes = $this->getNodes('trip_forum')->chunk($this->chunk, function ($nodes) use (&$i) {
            
            if ($i++ > $this->chunkLimit()) return false;
            
            foreach ($nodes as $node)
            {
                if (!$this->filterTerms($node->nid, [821, 825, 763])) // Reisikirjad, Sooduspakkumised, Reisiveeb
                {
                    $model = 'App\Content';
                
                    $this->convertNode($node, $model, 'forum');

                    $this->convertNodeDestinations($node);
                    $this->convertNodeTopics($node);
                    $this->newNodeTopics($node);
                } 
            }
        
        });

    }


    public function handle()
    {
        $this->convert();
        
    }
}
