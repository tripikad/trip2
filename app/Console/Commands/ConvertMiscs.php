<?php

namespace App\Console\Commands;

class ConvertMiscs extends ConvertBase
{

    protected $signature = 'convert:miscs';

    public function convertMiscNodes()
    {
        $nodes = $this->getNodes('trip_forum_other')->get();

        $this->info('Converting misc forum');
        $this->output->progressStart(count($nodes));

        foreach($nodes as $node) {

            $node->title = $node->title . ', vabal teemal';

            $this->convertNode($node, '\App\Content', 'forum');

            $this->convertNodeDestinations($node);
            $this->convertNodeTopics($node);
            $this->newNodeTopics($node);

            $this->output->progressAdvance();

        }

        $this->output->progressFinish();
    
    }

    public function convertForumNodes()
    {

        $nodes = $this->getNodes('trip_forum')
            ->join('term_node', 'term_node.nid', '=', 'node.nid')
            ->where('term_node.tid', '=', 763) // Reisiveeb
            ->get();


        $this->info('Converting misc forum (from general forum)');
        $this->output->progressStart(count($nodes));

        foreach($nodes as $node) {

            $node->title = $node->title . ', reisiveebist';

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
        $this->convertMiscNodes();
        $this->convertForumNodes();
    }
}
