<?php

namespace App\Console\Commands;

class ConvertBlogs extends ConvertBase
{
    protected $signature = 'convert:blogs {--take=10}';

    public function convertBlogNodes()
    {
        $nodes = $this->getNodes('trip_blog')->get();

        $this->info('Converting blogs');
        $this->output->progressStart(count($nodes));

        foreach ($nodes as $node) {

            // Find the image embedded in body

            $pattern = "/.*\s*<!--\s*FRONTIMG:\s*(.*)\s*-->.*/";

            if (preg_match($pattern, $node->body, $matches)) {
                $node->body = preg_replace($pattern, '', $node->body);
            }

            if ($this->convertNode($node, 'App\Content', 'blog')) {
                $this->convertNodeDestinations($node);

                $pattern = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/";

                if (preg_match_all($pattern, $node->body, $matches)) {
                    $this->convertUrl($node->nid, $matches[0][0], 'App\Content');
                }
            }

            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
    }

    public function convertForumNodes()
    {
        $nodes = $this->getNodes('trip_forum')
            ->join('term_node', 'term_node.nid', '=', 'node.nid')
            ->where('term_node.tid', '=', 821) // Reisikirjad
            ->get();

        $this->info('Converting blogs from forum');
        $this->output->progressStart(count($nodes));

        foreach ($nodes as $node) {
            if ($this->convertNode($node, '\App\Content', 'blog')) {
                $this->convertNodeDestinations($node);
            }

            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
    }

    public function handle()
    {
        $this->convertBlogNodes();
        $this->convertForumNodes();
    }
}
