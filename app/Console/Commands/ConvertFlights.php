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
            ->select(
                'node.*',
                'node_revisions.*',
                'content_type_lennufirmade_sooduspakkumine.*',
                'content_field_flightperiod.*'
            )
            ->get();

        $this->info('Converting flight offers');
        $this->output->progressStart(count($nodes));

        foreach($nodes as $node)
        {

            /*
            
            $fields = [
                'field_salesperiod_value',
                'field_salesperiod_value2',
                'field_flightperiod_value',
                'field_flightperiod_value2',
                'field_originatingcities_value',
                'field_tripeecomment_value',
            ];

            */

            $node->start_at = isset($node->field_salesperiod_value) ? $this->formatDateTime($node->field_salesperiod_value) : null;
            $node->end_at = isset($node->field_salesperiod_value2) ? $this->formatDateTime($node->field_salesperiod_value2) : null;

            if ($this->convertNode($node, 'App\Content', 'flight')) {

                $this->convertNodeDestinations($node);
                $this->convertNodeCarriers($node);

                if ($url = $node->field_linktooffer_url)
                {   
                    $this->convertUrl($node->nid, $url, 'App\Content');
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
            ->where('term_node.tid', '=', 825) // Sooduspakkumised
            ->get();

        $this->info('Converting flight offers from forum');
        $this->output->progressStart(count($nodes));

        foreach($nodes as $node)
        {
            $node->title = $node->title . ', from forum';
            
            $this->convertNode($node, 'App\Content', 'flight');

            $this->convertNodeDestinations($node);

            $this->output->progressAdvance();

        }

        $this->output->progressFinish();
    }

    public function handle()
    {
        $this->convertFlightNodes();
        // $this->convertForumNodes();
    }
}