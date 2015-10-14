<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StyleguideTest extends TestCase
{

    public function test_seeing_styleguide_without_logging_in()
    {
        
        $this->visit('/styleguide')
             ->see('Styleguide');

    }

}