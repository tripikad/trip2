<?php

namespace App\Console\Commands;

class ConvertTravelmates extends ConvertBase
{

    protected $signature = 'convert:travelmates';


    public function convert()
    {
        $nodes = $this->getNodes('trip_forum_travelmate')
            ->join('content_field_reisitoimumine', 'content_field_reisitoimumine.nid', '=', 'node.nid')
            ->join('content_field_reisikestvus', 'content_field_reisikestvus.nid', '=', 'node.nid')
            ->join('content_field_millistkaaslastsoovidleida', 'content_field_millistkaaslastsoovidleida.nid', '=', 'node.nid')
            ->get();

        foreach($nodes as $node)
        {   
  
            $node->body = join('\n', [
                'STARTS AT: ' . $this->formatTimestamp($node->field_reisitoimumine_value),
                'DURATION: ' . $node->field_reisikestvus_value,  
                'KIND: ' . $node->field_millistkaaslastsoovidleida_value  
                $node->body,
            ]);

            $this->convertNode($node, '\App\Content', 'travelmate');
            
            $this->convertNodeDestinations($node);
            $this->convertNodeTopics($node);

        }
    }

    public function handle()
    {
        $this->convert();
    }

}