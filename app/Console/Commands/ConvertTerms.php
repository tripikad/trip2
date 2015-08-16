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
        $this->output->progressStart(count($terms));

        foreach($terms as $term)
        {   
            $this->createDestination($term);
            $this->output->progressAdvance();
      
        }

        Destination::rebuild(true);

        $this->output->progressFinish();

    }

    public function cleanupDestinations()
    {
        $destinations = Destination::where('id', '>', 8)->where('id', '!=', 819)->get();

        foreach($destinations as $destination) {

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
        $this->output->progressStart(count($terms));

        foreach($terms as $term)
        {
            if ($term = $this->processTopic($term))
            {
                $this->createTerm($term, '\App\Topic');     
            }

            $this->output->progressAdvance();

        }

        $this->output->progressFinish();

    }


    public function addTopics()
    {

        $terms = $this->getNewTopics();        

        $this->info('Adding new tags');
        $this->output->progressStart(count($terms));

        foreach($terms as $term)
        {   
            
            $this->createTerm((object) $term, '\App\Topic');     
        
            $this->output->progressAdvance();

        }

        $this->output->progressFinish();

    }


    public function convertCarriers()
    {
        $terms = $this->getTerms(23)->get(); // Lennufirma

        $this->info('Converting carriers');
        $this->output->progressStart(count($terms));

        foreach($terms as $term)
        {
            $this->createTerm($term, '\App\Carrier');

            $this->output->progressAdvance();

        }
    
        $this->output->progressFinish();

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
