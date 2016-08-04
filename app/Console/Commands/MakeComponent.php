<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

class MakeComponent extends Command
{

    protected $signature = 'make:component { name } {--vue}';

    public function handle()
    {

        $name = $this->argument('name');
        $dir = "resources/views/v2/components/$name"; 
        
        Storage::disk('root')->makeDirectory($dir);

        $element = 'title';

        $css = [
            "@import \"variables\";",
            ".$name {",
            "}",
            "    .$name"."__"."$element {",
            "    }\n"
        ];

        Storage::disk('root')->put("$dir/$name.css", implode("\n\n", $css));

        $vue = [
            "<template>",
            "",
            "    <div class=\"$name\" :class=\"isclasses\">",
            "",
            "        <div class=\"$name"."__"."$element\">",
            "",
            "            {{ title }} {{ message }}",
            "",
            "        </div>",
            "",
            "    </div>",
            "",
            "</template>",
            "",
            "<script>",
            "",
            "    export default {",
            "",
            "        props: {",
            "            isclasses: { default: '' },", 
            "            title: { default: '$name' }", 
            "        },",
            "",
            "        data() {",
            "            return {", 
            "                message: 'from Vue'",
            "            }",
            "        }",
            "",
            "    }",
            "",
            "</script>\n"
        ];

        $blade = [
            "@php",
            "\$title = \$title ?? '';",
            "@endphp",
            "<div class=\"$name {{ \$isclasses }}\">",
            "    <div class=\"$name"."__"."$element\">",
            "        {{ \$title }}",
            "    </div>",
            "</div>\n"
        ];

        if ($this->option('vue')) {

            Storage::disk('root')->put("$dir/$name.vue", implode("\n", $vue));
            
            $this->info("\nVue component $dir created\n");
            $this->line("Your next steps:\n");
            $this->line("    1. Edit resources/views/v2/main.js to import your new component\n");
            $this->line("    2. Run gulp v2\n");
            $this->line("    3. Add a following line to app/Http/Controllers/StyleguideController.php\n");
            $this->line("       ->push(component('$name')->with('title', 'I am $name'))\n");
            
        } else {

            Storage::disk('root')->put("$dir/$name.blade.php", implode("\n\n", $blade));
            $this->info("\nBlade component $dir created\n");
            $this->line("Your next steps:\n");
            $this->line("    1. Run gulp v2\n");
            $this->line("    2. Add a following line to app/Http/Controllers/StyleguideController.php\n");
            $this->line("       ->push(component('$name')->with('title', 'I am $name'))\n");
            
        }


    }

}
