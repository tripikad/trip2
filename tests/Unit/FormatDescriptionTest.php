<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Image;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class FormatDescriptionTest extends TestCase
{

    use DatabaseTransactions;

    public function test_description_formatting_is_removed()
    {
        $cases = [
            [
                ' Hello ',
                'Hello',
                'Output should be trimmed from extra spacing in the beginning and the end',
            ],
            [
                'Hello [[123]]',
                'Hello',
                'Image references should be removed',
            ],
            [
                'Hello <a href="http://google.com">Google</a>',
                'Hello Google',
                'HTML links should be removed',
            ],
            [
                'Hello [Google](http://google.com)',
                'Hello Google',
                'Markdown links should be removed',
            ],
            [
                "\nHello\rGoogle\t",
                'Hello Google',
                'Newlines and tabs should be removed',
            ],
        ];

        foreach ($cases as $case) {
            $this->assertEquals($case[1], format_description($case[0]), $case[2]);
        }
    }

    public function test_description_images_are_removed()
    {
        $image = Image::create(['filename' => str_random(6).'.jpg']);
        
        $cases = [
            [
                'Hello [['.$image->id.']]',
                'Hello',
                'Image references should be removed'
            ]
        ];

        foreach ($cases as $case) {
            $this->assertEquals($case[1], format_description($case[0]), $case[2]);
        }
    }
}
