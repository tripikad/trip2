<?php

namespace App\Console\Commands;

class ConvertBuysells extends ConvertBase
{

    protected $signature = 'convert:buysells';


    public function convert()
    {
        $nodes = $this->getNodes('trip_forum_buysell')
            ->join(
                'content_type_trip_forum_buysell',
                'content_type_trip_forum_buysell.nid',
                '=',
                'node.nid'
            )
            ->get();

        foreach($nodes as $node)
        {

            $node->title = $node->title . ', ost-müük';

            $category = $this->getNodeTerms($node->nid, [25]); // Kategooria
            $type = $this->getNodeTerms($node->nid, [22]); // Kuulutuse tüüp
            
            $node->category = $category ? $category[0]->name : null;
            $node->type = $type ? $type[0]->name : null;

            $fields = [
                'category',
                'type',
                'field_buysellprice_value',
                'field_buysellcontact_value'
            ];

            $node->body = $this->formatFields($node, $fields) . "\n\n" . $node->body;

            $this->convertNode($node, '\App\Content', 'forum');

        }
    }

    public function handle()
    {
        $this->convert();
    }

}