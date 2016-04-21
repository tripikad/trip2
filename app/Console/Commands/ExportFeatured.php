<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExportFeatured extends Command
{
    protected $signature = 'export:featured';

    public function handle()
    {
        $this->line("<?php\n\nreturn [");

        while ($row = fgetcsv(STDIN)) {
            if (preg_match('/\d+/', $row[2], $matches)) {
                $photo_id = $matches[0];
                $this->line("    $row[1] => $photo_id,");
            }
        }

        $this->line('];');
    }
}
