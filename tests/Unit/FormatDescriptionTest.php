<?php

namespace Tests\Unit;

use App\Image;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FormatDescriptionTest extends TestCase
{
    use DatabaseTransactions;

    public function test_description_formatting_is_removed()
    {
        $cases = [
      [' Hello ', 'Hello', 'Output should be trimmed from extra spacing in the beginning and in the end'],
      ['Hello <a href="http://google.com">Google</a>', 'Hello Google', 'HTML links should be removed'],
      ['Hello [Google](http://google.com)', 'Hello Google', 'Markdown links should be removed'],
      ["\nHello\rGoogle\t", 'Hello Google', 'Newlines and tabs should be removed']
    ];

        foreach ($cases as $case) {
            $this->assertEquals($case[1], format_description($case[0]), $case[2]);
        }
    }

    public function test_description_images_are_removed()
    {
        $image = Image::create(['filename' => str_random(6) . '.jpg']);

        $cases = [
      ['Hello [[' . $image->id . ']]', 'Hello', 'Existing image references should be removed'],
      [
        'Hello [[[' . $image->id . ']]](http://google.com)',
        'Hello',
        'Existing linked image references should be removed'
      ],
      ['Hello [[0]]', 'Hello [[0]]', 'Non-existing image references should be kept']
    ];

        foreach ($cases as $case) {
            $this->assertEquals($case[1], format_description($case[0]), $case[2]);
        }
    }
}
