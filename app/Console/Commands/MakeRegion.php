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
        $dir = "app/Http/ComponentGroups"; 
        
        $php = [
            "<?php",
            "namespace App\Http\ComponentGroups;",
            "use Illuminate\Http\Request;",
            "class $name {",
            "    public function render(Request \$request, \$content)\n    {",
            "        return component('Body')\n            ->with('body', \$content->body);",
            "    }",
            "}\n"
        ];

        Storage::disk('root')->put("$dir/$name.php", implode("\n\n", $php));

        $this->line("$dir/$name.php created");

    }

}







