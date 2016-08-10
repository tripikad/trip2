<?php

namespace App\Console\Commands;

class ConvertFeatured extends ConvertBase
{
    protected $signature = 'convert:featured';

    public function convert()
    {
        $nodes = \DB::connection($this->connection)
            ->table('node')
            ->join('node_revisions', 'node_revisions.nid', '=', 'node.nid')
            ->select('node.*', 'node_revisions.body')
            ->where('node.uid', '>', 0)
            ->where('node.status', '=', 1)
            ->where('node.type', '=', 'trip_image')
            ->orderBy('node.last_comment', 'desc')
            ->join('content_field_image', 'content_field_image.nid', '=', 'node.nid')
            ->join('files', 'files.fid', '=', 'content_field_image.field_image_fid')
            ->join('term_node', 'term_node.nid', '=', 'node.nid')
            ->whereIn('node.nid', array_values(config('featured')))
            ->select(
                'node.*',
                'node_revisions.*',
                'files.*',
                'term_node.*'
            )
            ->get();

        $this->info('Converting featured photos');
        $this->output->progressStart(count($nodes));

        foreach ($nodes as $node) {
            if ($photo = $this->convertNode($node, '\App\Content', 'photo')) {
                $this->convertNodeDestinations($node);

                if ($node->filepath) {
                    $this->convertLocalImage(
                        $node->nid,
                        $node->filepath,
                        '\App\Content',
                        'photo',
                        $photo->created_at,
                        $photo->updated_at
                        );
                }
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
