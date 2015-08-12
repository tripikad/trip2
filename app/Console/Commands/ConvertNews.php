<?php

namespace App\Console\Commands;

class ConvertNews extends ConvertBase
{

    protected $signature = 'convert:news';


    public function convert()
    {
        $nodes = $this->getNodes('story')
            ->join('content_type_story', 'content_type_story.nid', '=', 'node.nid')
            ->select(
                'node.*',
                'node_revisions.*',
                'content_type_story.*'
            )
            ->get();

        $this->info('Converting news');
        $this->output->progressStart(count($nodes));

        foreach($nodes as $node) {

            // Find the image embedded in body

            $pattern = "/.*\s*<!--\s*FRONTIMG:\s*(.*)\s*-->.*/";
      
            if (preg_match($pattern, $node->body, $matches))
            {
                $node->body = preg_replace($pattern, '', $node->body);
            }

            // Convert the content

            $this->convertNode($node, '\App\Content', 'news');
      
            // Convert the image

            if ($matches && $matches[1]) {
                      
                $this->convertRemoteImage($node->nid, $matches[1], '\App\Content', 'news', 'photo');
            
            }

            // Convert the URL

            if ($url = $node->field_lyhiuudislink_url) {
                
                $this->convertUrl($node->nid, $url, '\App\Content');
            
            }

            $this->convertNodeDestinations($node);
            $this->convertNodeTopics($node);

            $this->output->progressAdvance();

        }

        $this->output->progressFinish();
        
    }

    public function handle()
    {
        $this->convert();
    }

}
