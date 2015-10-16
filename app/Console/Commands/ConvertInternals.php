<?php

namespace App\Console\Commands;

class ConvertInternals extends ConvertBase
{
    protected $signature = 'convert:internals';

    public function convert()
    {
        $nodes = $this->getNodes('trip_forum_editor')->get();

        $this->info('Converting internal forum');
        $this->output->progressStart(count($nodes));

        foreach ($nodes as $node) {
            if ($this->convertNode($node, '\App\Content', 'internal')) {

                // $this->convertNodeDestinations($node);
                // $this->convertNodeTopics($node);
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
