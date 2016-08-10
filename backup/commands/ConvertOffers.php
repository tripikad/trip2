<?php

namespace App\Console\Commands;

class ConvertOffers extends ConvertBase
{
    protected $signature = 'convert:offers';

    public function convert()
    {
        $nodes = $this->getNodes('trip_offer')
            ->join('content_type_trip_offer', 'content_type_trip_offer.nid', '=', 'node.nid')
            ->join('content_field_image', 'content_field_image.nid', '=', 'node.nid')
            ->join('files', 'files.fid', '=', 'content_field_image.field_image_fid')
            ->select(
                'node.*',
                'node_revisions.*',
                'content_type_trip_offer.*',
                'content_field_image.*',
                'files.*'
            )
            ->get();

        $this->info('Converting offers');
        $this->output->progressStart(count($nodes));

        foreach ($nodes as $node) {
            $locationMap = [
                1 => 'Eestist',
                2 => 'Lätist',
                3 => 'Soomest',
                4 => 'Rootsist',
                100 => 'Mujalt',
            ];

            $typeMap = [
                1 => 'Nädalalõpureis',
                2 => 'Eksootikareis',
                3 => 'Kruiis',
                4 => 'Ringreis',
                5 => 'Omal käel reis',
            ];

            $node->field_date_end_value = $this->formatTimestamp($node->field_date_end_value);
            $node->field_date_expire_comp_value = $this->formatTimestamp($node->field_date_expire_comp_value);
            $node->field_date_start_value = $this->formatTimestamp($node->field_date_start_value);
            $node->field_date_expire_value = $this->formatTimestamp($node->field_date_expire_value);
            $node->field_date_publish_value = $this->formatTimestamp($node->field_date_publish_value);
            $node->field_date_start_comp_value = $this->formatTimestamp($node->field_date_start_comp_value);

            $node->field_start_location_value = $locationMap[$node->field_start_location_value];
            $node->field_travel_type_value = $typeMap[$node->field_travel_type_value];

            $fields = [

                'field_title_value',

                'field_date_duration_value',
                'field_date_end_value',
                'field_date_expire_comp_value',
                'field_date_start_value',
                'field_date_expire_value',
                'field_date_publish_value',
                'field_date_start_comp_value',

                'field_price_value',
                'field_price_display_value',
                'field_price_flights_value',

                'field_travel_type_value',
                'field_start_location_value',

                'field_onhold_value',

                'field_includeinadvertising_value',
                'field_advertisinglimit_value',

                'field_description_value',
                'field_text_additional_value',
                'field_text_extras_value',
                'field_text_included_value',
                'field_text_itinerary_value',

            ];

            $node->body = $this->formatFields($node, $fields)."\n\n".$node->body;

            if ($this->convertNode($node, '\App\Content', 'offer')) {
                $this->convertNodeDestinations($node);

                if ($url = $node->field_link_url) {
                    $this->convertUrl($node->nid, $url, '\App\Content');
                }

                if ($node->filepath) {
                    $this->convertLocalImage($node->nid, $node->filepath, '\App\Content', 'offer', 'photo');
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

/*

content_field_hotels:
field_hotels_nid
delta

content_field_prices:
field_prices_value
delta

new Hotel;

node.type = trip_hotel
content_type_trip_hotel
field_rating_value

*/
