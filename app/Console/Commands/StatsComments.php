<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class StatsComments extends StatsBase
{

    protected $signature = 'stats:comments';

    public function getComments()
    {
        return DB::connection($this->connection)
            ->table('comments');
    }

    public function commentCount()
    {

        $this->line('Total,Published,Unpublished,%,Unknown');

        $total = $this->getComments()->count();
        $published = $this->getComments()->whereStatus(0)->count();
        $unpublished = $total - $published;
        $unknown = $this->getComments()->whereStatus(2)->count();

        $this->line(join(',', [
            $total,
            $published,
            $unpublished,
            $this->percent($total, $unpublished),
            $unknown
        ]));
    
    }

    public function handle()
    {

        $this->commentCount();
    
    }

}
