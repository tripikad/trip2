<?php

namespace App\Console\Commands;

class ConvertPhotos extends ConvertBase
{
    protected $signature = 'convert:photos';

    public function convert()
    {
        $nodes = $this->getNodes('trip_image')
            ->join('content_field_image', 'content_field_image.nid', '=', 'node.nid')
            ->join('files', 'files.fid', '=', 'content_field_image.field_image_fid')
            ->join('term_node', 'term_node.nid', '=', 'node.nid')
            ->whereNotIn('term_node.tid', [646]) // Mitte-reisipilt
            ->select(
                'node.*',
                'node_revisions.*',
                'files.*',
                'term_node.*'
            )
            ->get();

        $this->info('Converting photos');
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
