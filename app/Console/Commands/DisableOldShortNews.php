<?php

namespace App\Console\Commands;

use App\Content;
use Illuminate\Console\Command;

class DisableOldShortNews extends Command
{
    const FROM_DATE = '2017-06-01';

    protected $signature = 'disable:shortNews';

    public function handle()
    {
        $this->line('Changing status for old short news');

        Content::where('type', 'shortnews')->where('created_at', '<', self::FROM_DATE)->update(['status' => 0]);

        $this->line('Done');
    }
}