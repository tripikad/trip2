<?php namespace App\Console\Commands;

class ConvertTravelmates extends ConvertBase
{

    protected $signature = 'convert:travelmates';


    public function convert()
    {
        $nodes = $this->getNodes('trip_forum_travelmate')->get();

        foreach($nodes as $node)
        {   
  
            $this->convertNode($node, '\App\Content', 'travelmate');
            
            $this->convertNodeDestinations($node);

        }
    }

    public function handle()
    {
        $this->convert();
    }

}

/*
content_field_reisitoimumine:
field_reisitoimumine_value (timestamp)

content_field_reisikestvus:
field_reisikestvus_value
    
content_field_millistkaaslastsoovidleida:      
field_millistkaaslastsoovidleida
|
Kõik sobib
Mees
Naine
(+ ignore other values)

Reisistiil vid 5 

*/