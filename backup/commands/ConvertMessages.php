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
            ->latest('timestamp');
    }

    public function convertMessages()
    {
        $count = $this->getMessages()->count();

        $this->info('Converting messages');
        $this->output->progressStart(($this->take > $count) ? $count : $this->take);

        $nodes = $this->getMessages()->chunk($this->chunk, function ($nodes) use (&$i) {
            if ($i++ > $this->chunkLimit()) {
                return false;
            }

            foreach ($nodes as $node) {
                $index = DB::connection($this->connection)
                    ->table('pm_index')
                    ->where('mid', $node->mid)
                    ->where('deleted', 0);

                // Find first recepient who is not the sender

                $recepient = collect($index->pluck('uid'))
                    ->reject(function ($item) use ($node) {
                        return $item == $node->author;
                    })->shift();

                if (! Message::find($node->mid)
                    && $recepient
                    && $this->isUserConvertable($node->author)
                    && $this->isUserConvertable($recepient)
                ) {
                    $model = new Message;

                    $model->id = $node->mid;
                    $model->user_id_from = $node->author;
                    $model->user_id_to = $recepient;

                    $model->read = 1;

                    $body = $this->clean($node->body);

                    $model->body = $this->scrambleMessages ? $this->scrambleString($body) : $body;
                    $model->created_at = \Carbon\Carbon::createFromTimeStamp($node->timestamp);
                    $model->updated_at = \Carbon\Carbon::createFromTimeStamp($node->timestamp);

                    $model->save();

                    $this->convertUser($node->author);
                    $this->convertUser($recepient);
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
