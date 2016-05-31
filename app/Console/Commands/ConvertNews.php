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

        foreach ($nodes as $node) {

            // Find the image embedded in body

            $frontImagePattern = "/.*\s*<!--\s*FRONTIMG:\s*(.*)\s*-->.*/";

            if (preg_match($frontImagePattern, $node->body)) {
                $node->body = preg_replace($frontImagePattern, '', $node->body);
            }

            $imagePattern = '/(https?:\/\/.*\.(?:png|jpg|jpeg|gif))/i';

            if (preg_match_all($imagePattern, $node->body, $imageMatches)) {
                $images = (isset($imageMatches[0])) ? $imageMatches[0] : false;
            }

            $type = trim($node->body) == '' ? 'shortnews' : 'news';

            if ($type == 'shortnews') {
                $parts = explode('(', $node->title);
                $node->title = $parts[0];
            }

            // Convert the content

            if ($news = $this->convertNode($node, '\App\Content', $type)) {

                // Convert the images

                if ($images && count($images) > 0) {
                    $replaceImages = [];

                    foreach ($images as $index => $image) {
                        $newImage = $this->convertRemoteImage(
                            $node->nid,
                            $image,
                            '\App\Content',
                            'news',
                            $news->created_at,
                            $news->updated_at
                        );

                        $escapedImage = str_replace('/', '\/', $image);
                        $escapedImage = str_replace('.', '\.', $escapedImage);

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
                }

                $body = $news->body;

                foreach ($replaceImages as $replaceImage) {
                    $body = preg_replace($replaceImage['from'], $replaceImage['to'], $body);
                }

                $news->update(['body' => $this->convertLineendings($body)]);

                // Convert the URL

                if ($url = $node->field_lyhiuudislink_url) {
                    $this->convertUrl($node->nid, $url, '\App\Content');
                }

                $this->convertNodeDestinations($node);
                $this->convertNodeTopics($node);
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
