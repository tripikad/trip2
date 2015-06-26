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
            ->get();

        foreach($nodes as $node) {

            $this->convertNode($node, '\App\Content', 'photo');

            $this->convertNodeDestinations($node);

            if ($node->filepath) {

                $this->convertLocalImage($node->nid, $node->filepath, '\App\Content', 'photos');
            }

        }
    }

    public function handle()
    {
        $this->convert();
    }

}
