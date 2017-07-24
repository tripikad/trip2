<?php

namespace Tests\Unit;

use Tests\TestCase;

class FormatDescription extends TestCase
{

    public function test_description_is_sanitized_and_cleaned()
    {
        $cases = [
            [
                ' Hello ',
                'Hello',
                'Output should be trimmed from extra spacing in the beginning and the end'
            ],
            [
                'Hello [[123]]',
                'Hello',
                'Image references should be removed'
            ],
            [
                'Hello <a href="http://google.com">Google</a>',
                'Hello Google',
                'HTML links should be removed'
            ],
            [
                'Hello [Google](http://google.com)',
                'Hello Google',
                'Markdown links should be removed'
            ],
            [
                "\nHello\rGoogle\t",
                'Hello Google',
                'Newlines and tabs should be removed'
            ]
        ];

        foreach ($cases as $case) {
            $this->assertEquals($case[1], format_description($case[0]), $case[2]);
        }
    }
}
