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
            ->select(
                'node.*',
                'node_revisions.*',
                'content_field_reisitoimumine.*',
                'content_field_reisikestvus.*',
                'content_field_millistkaaslastsoovidleida.*'
            )->get();

        $this->info('Converting travelmates');
        $this->output->progressStart(count($nodes));

        foreach ($nodes as $node) {

            /*

            $fields = [
                'field_reisitoimumine_value',
                'field_reisikestvus_value',
                'field_millistkaaslastsoovidleida_value',
            ];

            */

            $node->start_at = $this->formatTimestamp($node->field_reisitoimumine_value);
            $node->duration = $this->cleanAll($node->field_reisikestvus_value);

            if ($this->convertNode($node, '\App\Content', 'travelmate')) {
                $this->convertNodeDestinations($node);
                $this->convertNodeTopics($node);
                $this->newNodeTopics($node);
            }

            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
    }

    public function handle()
    {
        $this->convert();
    }
}
