<?php

namespace App\Console\Commands;

class ConvertExpats extends ConvertBase
{

    protected $signature = 'convert:expats';

    public function convert()
    {
        $nodes = $this->getNodes('trip_forum_expat')->get();

        foreach($nodes as $node)
        {

            $node->title = $node->title . ', elust välismaal';

            $this->convertNode($node, '\App\Content', 'forum');

            $this->convertNodeDestinations($node);
            $this->convertNodeTopics($node);
            $this->newNodeTopics($node);
        }
    }

    public function handle()
    {
        $this->convert();
    }
}
