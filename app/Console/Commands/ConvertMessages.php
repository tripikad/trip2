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
            ->latest('timestamp');      
    
    }
    
    public function convertMessages()
    {

        $count = $this->getMessages()->count();

        $this->info('Converting messages');
        $this->output->progressStart(($this->take > $count) ? $count : $this->take);

        $nodes = $this->getMessages()->chunk($this->chunk, function ($nodes) use (&$i) {
            
            if ($i++ > $this->chunkLimit()) return false;

            foreach($nodes as $node) {

                if ($node->author !== $node->uid
                    && $this->isUserConvertable($node->author)
                    && $this->isUserConvertable($node->uid)
                ) {
        
                    $model = new Message;

                    $model->id = $node->mid;
                    $model->user_id_from = $node->author;
                    $model->user_id_to = $node->uid;
                    $model->body = $this->scrambleString(trim($node->body));
                    $model->created_at = \Carbon\Carbon::createFromTimeStamp($node->timestamp);  
                    $model->updated_at = \Carbon\Carbon::createFromTimeStamp($node->timestamp); 

                    $model->save();

                    $this->convertUser($node->author);
                    $this->convertUser($node->uid);
        
                }

                $this->output->progressAdvance();

            }

        });
    
        $this->output->progressFinish();

    }

    public function handle()
    {

        $this->convertMessages();

    }


}
