<?php

namespace App\Console\Commands;

use App\Content;
use App\Viewable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConvertViewables extends Command
{
  protected $signature = 'convert:viewables';

  protected $description = 'Converts activities table values to viewables table values';

  protected $forum_types = ['forum', 'buysell', 'expat', 'internal', 'misc'];

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    $this->info("\nConverting activities\n");
    DB::disableQueryLog();
    $content_type = 'App\Content';

    Content::whereIn('type', $this->forum_types)->chunk(200, function ($contents) use ($content_type) {
      foreach ($contents as $content) {
        $views_count = $content->views_count;
        if ($views_count) {
          Viewable::create([
            'viewable_id' => $content->id,
            'viewable_type' => $content_type,
            'count' => $views_count
          ]);
        }
      }
    });

    $this->info("\nDONE!\n");
  }
}
