<?php

namespace App\Console\Commands;

class ConvertTerms extends ConvertBase
{

    protected $signature = 'convert:terms';


    public function convertDestinations()
    {
        $terms = $this->getTerms(6)->get(); // Sihtkohad

        $this->info('Converting destinations');

        foreach($terms as $term)
        {   
            $this->createTerm($term, '\App\Destination', true);        
        }
    }


    public function convertTopics()
    {
        $terms = $this->getTerms([5, 9])->get(); // Reisistiilid, Rubriigid

        $this->info('Converting tags');

        foreach($terms as $term)
        {
            if ($term = $this->processTopic($term))
            {
                $this->createTerm($term, '\App\Topic');     
            }
        }

    }


    public function addTopics()
    {

        $terms = $this->getNewTopics();        

        $this->info('Adding new tags');

        foreach($terms as $term)
        {   
            
            $this->createTerm((object) $term, '\App\Topic');     
        
        }

    }


    public function convertCarriers()
    {
        $terms = $this->getTerms(23)->get(); // Lennufirma

        $this->info('Converting carriers');

        foreach($terms as $term)
        {
            $this->createTerm($term, '\App\Carrier');     
        }
    }


    public function handle()
    {
        $this->convertDestinations();
        $this->convertTopics();
        $this->addTopics();
        $this->convertCarriers();
        
    }

}
