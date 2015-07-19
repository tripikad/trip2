<?php

namespace App\Console\Commands;

use DB;
use App\Follow;

class ConvertFollows extends ConvertBase
{

    protected $signature = 'convert:follows';

    public function getFollows()
    {
    
        return DB::connection($this->connection)
            ->table('sein_subscribe')
            ->latest('subscribe_id')
            ->whereActive(1)
            ->skip($this->skip)
            ->take($this->take);
    
    }

    public function convertFollows()
    {
        $follows = $this->getFollows()->get(); 

        $this->info('Converting follows (subscriptions)');
        $this->output->progressStart(count($follows));

        foreach($follows as $follow)
        {   

            if ($node = $this->getNode($follow->nid)) {

                $model = new Follow;

                $model->id = $follow->subscribe_id;
                $model->user_id = $follow->uid;
                $model->followable_type = 'App\Content';
                $model->followable_id = $follow->nid;

                $model->save();

                $this->convertUser($follow->uid);
              
                $this->convertNode($node, '\App\Content', 'forum');

                $this->output->progressAdvance();

            }
              
        }

        $this->output->progressFinish();

    }

    public function handle()
    {
        
        $this->convertFollows();
        
    }

}
