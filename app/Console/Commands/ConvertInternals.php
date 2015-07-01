<?php

namespace App\Console\Commands;

class ConvertInternals extends ConvertBase
{

    protected $signature = 'convert:internals';

    public function convert()
    {
        $nodes = $this->getNodes('trip_forum_editor')->get();

        foreach($nodes as $node)
        {
            $this->convertNode($node, '\App\Content', 'internal');
            
            $this->convertNodeDestinations($node);
            $this->convertNodeTopics($node);

        }
    }

    public function handle()
    {
        $this->convert();
    }

}
