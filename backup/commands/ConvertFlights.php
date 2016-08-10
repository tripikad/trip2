<?php

namespace App\Console\Commands;

class ConvertFlights extends ConvertBase
{
    protected $signature = 'convert:flights';

    public function convertFlightNodes()
    {
        $flightNodes = $this->getNodes('lennufirmade_sooduspakkumine')
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
            );

        $this->info('Converting flight offers');

        $count = $flightNodes->count();

        $this->output->progressStart($this->take < $count ? $this->take : $count);

        $nodes = $flightNodes->skip($this->skip)->chunk($this->chunk, function ($nodes) use (&$i) {
            if ($i++ > $this->chunkLimit()) {
                return false;
            }

            foreach ($nodes as $node) {
                $images = false;

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

                if (preg_match('/(\d+)€/', $node->title, $matches)) {
                    $node->price = $matches[1];
                    $node->title = preg_replace('/[al]*\.?\s?(\d+)€/', '', $node->title);
                }

                $node->body = str_replace('src="/images', 'src="http://www.trip.ee/images', $node->body);

                $imagePattern = '/(https?:\/\/.*\.(?:png|jpg|jpeg|gif))/i';

                if (preg_match_all($imagePattern, $node->body, $imageMatches)) {
                    $images = (isset($imageMatches[0])) ? $imageMatches[0] : null;
                }

                // Convert the content

                if ($flight = $this->convertNode($node, '\App\Content', 'flight')) {

                    // Convert the image

                    if ($images && count($images) > 0) {
                        $replaceImages = [];

                        foreach ($images as $index => $image) {
                            $newImage = $this->convertRemoteImage(
                                $node->nid,
                                $image,
                                '\App\Content',
                                'flight',
                                $flight->created_at,
                                $flight->updated_at
                            );

                            $escapedImage = str_replace('/', '\/', $image);
                            $escapedImage = str_replace('.', '\.', $escapedImage);
                            $escapedImage = str_replace('-', '\-', $escapedImage);

                            if ($index < 1 || ! $newImage) {
                                $replaceImages[] = [
                                    'from' => '/<img.*src="?'.$escapedImage.'"?.*\/?>\n?/i',
                                    'to' => '',
                                ];
                            } else {
                                $replaceImages[] = [
                                    'from' => '/<img.*src="?'.$escapedImage.'"?.*\/?>/i',
                                    'to' => "[[$newImage->id]]",
                                ];
                            }
                        }

                        $body = $flight->body;

                        foreach ($replaceImages as $replaceImage) {
                            $body = preg_replace($replaceImage['from'], $replaceImage['to'], $body);
                        }

                        $flight->update(['body' => $this->convertLineendings($body)]);
                    }

                    $this->convertNodeDestinations($node);

                    $this->convertNodeCarriers($node);

                    if ($url = $node->field_linktooffer_url) {
                        $this->convertUrl($node->nid, $url, 'App\Content');
                    }
                }

                $this->output->progressAdvance();
            }
        });

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

        foreach ($nodes as $node) {
            $node->title = $node->title.', from forum';

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
