<?php

namespace App\Console\Commands;

class ConvertExpats extends ConvertBase
{

    protected $signature = 'convert:expats';

    public function convert()
    {
        $nodes = $this->getNodes('trip_forum_expat')->get();

        $this->info('Coverting Expats');
        $this->output->progressStart(count($nodes));

        foreach($nodes as $node) {

            $node->title = $node->title . ', elust välismaal';

            $this->convertNode($node, '\App\Content', 'forum');

            $this->convertNodeDestinations($node);
            $this->convertNodeTopics($node);
            $this->newNodeTopics($node);

            $this->output->progressAdvance();

        }

        $this->output->progressFinish();
    
    }

    public function handle()
    {
        $this->convert();
    }
}
