<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

class MakeRegion extends Command
{
    protected $signature = 'make:region { name }';

    public function handle()
    {
        $name = $this->argument('name');
        $dir = 'app/Http/Regions';

        $php = [
            '<?php',
            "namespace App\Http\Regions;",
            "class $name\n{",
            "    public function render(\$post)\n    {",
            "        return component('Body')\n            ->with('body', \$post->body);",
            '    }',
            "}\n",
        ];

        Storage::disk('root')->put("$dir/$name.php", implode("\n\n", $php));

        $this->info("\n$dir/$name.php created\n");
        $this->line("Your next steps:\n");
        $this->line("    1. Add a following line to app/Http/Controllers/StyleguideController.php\n");
        $this->comment("       ->push(region('$name', (object) ['body' => 'I am $name region']))\n");
    }
}
