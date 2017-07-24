<?php

namespace Tests\Unit;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class FormatBodyTest extends TestCase
{

    use DatabaseTransactions;

    public function test_body_is_formatted()
    {
        $cases = [
            [
                "* Hello\n* World",
                "<ul>\n<li>Hello</li>\n<li>World</li>\n</ul>",
                '* are converted to unordered lists',
            ],
            [
                'Hello [Google](http://google.com)',
                '<p>Hello <a href="http://google.com" target="_blank">Google</a></p>',
                'External Markdown links should be converted to HTML links opening in new window',
            ],
        ];

        foreach ($cases as $case) {
            $this->assertEquals($case[1], format_body($case[0]), $case[2]);
        }
    }
}
