<?php

namespace App\Console\Commands;

class ConvertBuysells extends ConvertBase
{
    protected $signature = 'convert:buysells';

    public function convert()
    {
        $buysellTypeMap = [
            'Müün' => 'M: ',
            'Ostan' => 'O: ',
            'Annan üürile' => '',
            'Võtan üürile' => '',
            'Annan ära' => '',
            'Muu' => '',
        ];

        $nodes = $this->getNodes('trip_forum_buysell')
            ->join(
                'content_type_trip_forum_buysell',
                'content_type_trip_forum_buysell.nid',
                '=',
                'node.nid'
            )
            ->select(
                'node.*',
                'node_revisions.*',
                'content_type_trip_forum_buysell.*'
            )
            ->get();

        $this->info('Converting Buysells');
        $this->output->progressStart(count($nodes));

        foreach ($nodes as $node) {
            $category = $this->getNodeTerms($node->nid, [25]); // Kategooria
            $type = $this->getNodeTerms($node->nid, [22]); // Kuulutuse tüüp

            $node->category = $category ? $category[0]->name : null;
            $node->type = $type ? $type[0]->name : null;

            /*

            $fields = [
                'category',
                'type',
                'field_buysellprice_value',
                'field_buysellcontact_value'
            ];

            */

            if ($node->type) {
                $node->title = $buysellTypeMap[$node->type].preg_replace('/^(M|O|Müün|Ostan):/i', '', $node->title);
            }

            if ($price = $node->field_buysellprice_value) {
                if (is_numeric($price)) {
                    $price = $price.'€';
                } else {
                    $price = mb_convert_case(preg_replace('/( eur|euri|eurot|.-)/i', '€', $price), MB_CASE_LOWER);
                }

                $node->title = preg_replace('/\s?Kiire\!?\s?/i', '', $node->title).', hind '.$price;
            }

            if ($node->field_buysellcontact_value) {
                $node->body = $node->body."\n\nKontakt: ".$node->field_buysellcontact_value;
            }

            $this->convertNode($node, '\App\Content', 'buysell');

            $this->convertNodeTopics($node);
            $this->newNodeTopics($node);

            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
    }

    public function handle()
    {
        $this->convert();
    }
}
