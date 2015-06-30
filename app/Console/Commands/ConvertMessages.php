<?php

namespace App\Console\Commands;

use DB;
use App\Message;

class ConvertMessages extends ConvertBase
{

    protected $signature = 'convert:messages';

    public function getMessages()
    {
    
        return DB::connection($this->connection)
            ->table('pm_message')
            ->join('pm_index', 'pm_index.mid', '=', 'pm_message.mid')        
            ->take(10);
    
    }
    
    public function convertMessages()
    {
        $nodes = $this->getMessages()->get();

        foreach($nodes as $node)
        {

            $model = new Message;

            $model->user_id_from = $node->author;
            $model->user_id_to = $node->uid;
            $model->title = $this->scrambleString(trim($node->subject));
            $model->body = $this->scrambleString(trim($node->body));
            $model->created_at = \Carbon\Carbon::createFromTimeStamp($node->timestamp);  
            $model->updated_at = \Carbon\Carbon::createFromTimeStamp($node->timestamp); 

            $model->save();

            $this->convertUser($node->author);
            $this->convertUser($node->uid);

        }

    }

    public function handle()
    {

        $this->convertMessages();

    }


}
