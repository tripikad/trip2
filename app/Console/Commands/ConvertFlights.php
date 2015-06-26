<?php

namespace App\Console\Commands;

class ConvertFlights extends ConvertBase
{

    protected $signature = 'convert:flights';

    public function convertFlightNodes()
    {
        $nodes = $this->getNodes('lennufirmade_sooduspakkumine')
            ->join(
                'content_type_lennufirmade_sooduspakkumine',
                'content_type_lennufirmade_sooduspakkumine.nid',
                '=',
                'node.nid'
            )
            ->join(
                'content_field_flightperiod',
                'content_field_flightperiod.nid',
                '=',
                'node.nid'
            )
            ->get();

        foreach($nodes as $node)
        {

            $node->body = join('\n\n', [
                $node->body,
                'TRIP COMMENT: ' . $node->field_tripeecomment_value
            ]);

            $this->convertNode($node, 'App\Content', 'flight');

            $this->convertNodeDestinations($node);
            $this->convertNodeCarriers($node);

            if ($url = $node->field_linktooffer_url)
            {   
                $this->convertUrl($node->nid, $url, 'App\Content');
            }

        }
    }

    public function convertForumNodes()
    {

        $nodes = $this->getNodes('trip_forum')
            ->join('term_node', 'term_node.nid', '=', 'node.nid')
            ->where('term_node.tid', '=', 825) // Sooduspakkumised
            ->get();

        foreach($nodes as $node)
        {
            $node->title = 'FROM FORUM: ' . $node->title;
            
            $this->convertNode($node, 'App\Content', 'flight');

            $this->convertNodeDestinations($node);

        }
    }

    public function handle()
    {
        $this->convertFlightNodes();
        $this->convertForumNodes();
    }
}


/*
content_type_lennufirmade_sooduspakkumine:
field_salesperiod_value
field_salesperiod_value2      
field_originatingcities_value

content_field_flightperiod:
field_flightperiod_value (datetime)
field_flightperiod_value2 (datetime)
delta
*/