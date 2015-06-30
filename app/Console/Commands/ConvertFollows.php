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

        foreach($follows as $follow)
        {   
            
            $model = new Follow;

            $model->user_id = $follow->uid;
            $model->followable_type = 'App\Content';
            $model->followable_id = $follow->nid;

            $model->save();

            $this->convertUser($follow->uid);
        
        }
    }

    public function handle()
    {
        
        $this->convertFollows();
        
    }

}
