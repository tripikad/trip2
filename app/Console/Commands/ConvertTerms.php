<?php

namespace App\Console\Commands;

use App\Destination;

class ConvertTerms extends ConvertBase
{

    protected $signature = 'convert:terms';

    public function createDestination($term)
    {

        if (! Destination::find($term->tid)) {

            $model = new Destination;

            $model->id = $term->tid;
            $model->name = $this->cleanAll($term->name);
            
            $model->save();

            if ($term->parent) {

                $parent = Destination::find($term->parent);
                
                if (! $parent) {
                
                    $parent = $this->createDestination($this->getTermById($term->parent));

                }
                
                $model->makeChildOf($parent);         

            }

            return $model;

        }

    }

    public function convertDestinations()
    {
        $terms = $this->getTerms(6)->get(); // Sihtkohad

        $this->info('Converting destinations');

        foreach($terms as $term)
        {   
            $this->createDestination($term);        
        }
    }

    public function cleanupDestinations()
    {
        $destinations = Destination::where('id', '>', 8)->where('id', '!=', 819)->get();

        foreach($destinations as $destination)
        {   
            if ($destination->isRoot()) {
                
                $parent_id = $this->getTermById($destination->id)->parent;
                $parent = Destination::find($parent_id);

                $destination->makeChildOf($parent);         

            }     
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
        $this->cleanupDestinations();
        $this->convertTopics();
        $this->addTopics();
        $this->convertCarriers();
        
    }

}
