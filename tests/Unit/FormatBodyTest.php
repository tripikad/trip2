<?php

namespace Tests\Unit;

use App\Image;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FormatBodyTest extends TestCase
{
    use DatabaseTransactions;

    public function test_body_text_is_formatted()
    {
        $cases = [
            [
                '**Hello** World',
                '<p><strong>Hello</strong> World</p>',
                'Double asterisks are converted to HTML strong tag',
            ],
            [
                '_Hello_ World',
                '<p><em>Hello</em> World</p>',
                'Underlines are converted to HTML em tag',
            ],
            [
                "* Hello\n* World",
                "<ul>\n<li>Hello</li>\n<li>World</li>\n</ul>",
                '* are converted to unordered lists',
            ],
            [
                'Hello [Google](http://google.com)',
                '<p>Hello <a href="http://google.com" target="_blank">Google</a></p>',
                'External Markdown links should be converted to HTML links opening in a new window',
            ],
        ];

        foreach ($cases as $case) {
            $this->assertEquals($case[1], format_body($case[0]), $case[2]);
        }
    }

    public function test_body_images_are_formatted()
    {
        $image = Image::create(['filename' => str_random(6).'.jpg']);

        $cases = [
            [
                'Hello [['.$image->id.']]',
                '<p>Hello <img src="'.$image->preset('large').'" /></p>',
                'Existing image references should be replaced with HTML image tag',
            ],
            [
                'Hello [[0]]',
                '<p>Hello [[0]]</p>',
                'Non-existing image references should be kept as is',
            ],
        ];

        foreach ($cases as $case) {
            $this->assertEquals($case[1], format_body($case[0]), $case[2]);
        }
    }
}
