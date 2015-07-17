<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BasicTest extends TestCase
{

    public function test_seeing_frontpage_without_logging_in()
    {
        
        $this->visit('/')
             ->see(config('site.name'));

    }


    public function test_seeing_content_pages_without_logging_in()
    {
        
        foreach (config('content.types') as $type => $typeConf) {

        $this->visit('/content/' . $type)
            ->see(config('site.name'));

        }

    }

}