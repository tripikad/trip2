<?php

namespace App\Console\Commands;

class ConvertMiscs extends ConvertBase
{

    protected $name = 'convert:miscs';

    public function convertMiscNodes()
    {
        $nodes = $this->getNodes('trip_forum_other')->get();

        foreach($nodes as $node)
        {

            $node->title = $node->title . ', vabal teema';

            $this->convertNode($node, '\App\Content', 'forum');

            $this->convertNodeDestinations($node);
            $this->convertNodeTopics($node);
            $this->newNodeTopics($node);
        }
    }

    public function convertForumNodes()
    {

        $nodes = $this->getNodes('trip_forum')
            ->join('term_node', 'term_node.nid', '=', 'node.nid')
            ->where('term_node.tid', '=', 763) // Reisiveeb
            ->get();

        foreach($nodes as $node)
        {
            $node->title = $node->title . ', reisiveebist';

            $this->convertNode($node, '\App\Content', 'forum');

            $this->convertNodeDestinations($node);
            $this->convertNodeTopics($node);
            $this->newNodeTopics($node);
        }
    }

    public function fire()
    {
        $this->convertMiscNodes();
        $this->convertForumNodes();
    }
}
