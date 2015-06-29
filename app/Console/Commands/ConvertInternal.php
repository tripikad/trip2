<?php

namespace App\Console\Commands;

class ConvertInternal extends ConvertBase
{

    protected $signature = 'convert:internal';

    public function convert()
    {
        $nodes = $this->getNodes('trip_forum_editor')->get();

        foreach($nodes as $node)
        {
            $this->convertNode($node, '\App\Content', 'forum');
            
            $this->convertNodeDestinations($node);
            $this->convertNodeTopics($node);

        }
    }

    public function handle()
    {
        $this->convert();
    }

}
