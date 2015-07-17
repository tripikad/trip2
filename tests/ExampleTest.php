<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MainTest extends TestCase
{

    public function i_see_frontpage_without_logging_in()
    {
        $this->visit('/')
             ->see(conf('site.name'));
    }
    
    public function i_see_content_pages_without_logging_in()
    {
        foreach (config('content.types') as $type => $typeConf) {

            $this->visit('/content/' . $type)
                 ->see(trans('content.index.title'));

        }
    }

}
