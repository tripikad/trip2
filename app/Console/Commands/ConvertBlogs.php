<?php namespace App\Console\Commands;

class ConvertBlogs extends ConvertBase
{

    protected $name = 'convert:blogs';


    public function convertBlogNodes()
    {

        $nodes = $this->getNodes('trip_blog')->get();

        foreach($nodes as $node)
        {
            $this->convertNode($node, '\App\Content', 'blog');

            $this->convertNodeDestinations($node);

            $pattern = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/";

            if (preg_match_all($pattern, $node->body, $matches))
            {
                $this->convertUrl($node->nid, $matches[0][0], '\App\Content');
            }

        }
    }

    public function convertForumNodes()
    {

        $nodes = $this->getNodes('trip_forum')
            ->join('term_node', 'term_node.nid', '=', 'node.nid')
            ->where('term_node.tid', '=', 821) // Reisikirjad
            ->get();

        foreach($nodes as $node)
        {
            $node->title = $node->title . ', foorumist'
            $this->convertNode($node, '\App\Content', 'blog');
            
            $this->convertNodeDestinations($node);
        }
    }

    public function fire()
    {
        $this->convertBlogNodes();
        $this->convertForumNodes();
    }

}
